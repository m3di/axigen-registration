<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

abstract class ModelManager extends Controller implements ModelManagerContract
{
    protected static $address = [
        'list'   => "",
        'create' => "new/",
        'edit'   => "{[single.en]}/edit/",
        'delete' => "{[single.en]}/delete/",
    ];

    static $modelPerPage = 30;
    protected static $listView   = 'model-manager.list';
    protected static $editView   = 'model-manager.edit';
    protected static $createView = 'model-manager.create';
    protected static $routeNamePrefix = '';

    private static function getLanguageMap() {
        static $map = null;

        if (! is_array($map)) {
            $map = [
                'single' => [
                    'fa' => static::getSingularFa(),
                    'en' => static::getSingularEn(),
                ],
                'plural' => [
                    'fa' => static::getPluralFa(),
                    'en' => static::getPluralEn(),
                ],
            ];
        }

        return $map;
    }

    public static function RegisterRoutes()
    {
        \Route::group(['prefix' => ''], function () {
            \Route::get(
                static::getRouteAddress('list'),
                '\\' . static::class . '@ShowModelList'
            )
                ->name(static::getRouteName('list'));

            \Route::get(
                static::getRouteAddress('create'),
                '\\' . static::class . '@NewModelForm'
            )
                ->name(static::getRouteName('create'));

            \Route::post(
                static::getRouteAddress('create'),
                '\\' . static::class . '@NewModelStore'
            );

            \Route::get(
                static::getRouteAddress('edit'),
                '\\' . static::class . '@EditModelForm'
            )
                ->name(static::getRouteName('edit'))
                ->where(static::getSingularEn(), '\d+');

            \Route::post(
                static::getRouteAddress('edit'),
                '\\' . static::class . '@EditModelStore'
            )
                ->where(static::getSingularEn(), '\d+');

            \Route::get(
                static::getRouteAddress('delete'),
                '\\' . static::class . '@RemoveModel'
            )
                ->name(static::getRouteName('delete'))
                ->where(static::getSingularEn(), '\d+');
        });
    }

    protected static function getRequestedModel()
    {
        $route = \Route::current();
        $mn = static::getModel();

        if (($model = $route->{static::getSingularEn()}) instanceof $mn)
            return $model;

        return call_user_func([$mn, 'findOrFail'], $model);
    }

    public function ShowModelList()
    {
        return view(static::$listView)->with(array_merge($this->getViewParameters(), [
            'models' => $this->getModelPaginator()
        ]));
    }

    public function NewModelForm() {
        return view(static::$createView)->with($this->getViewParameters());
    }

    public function NewModelStore(Request $request) {
        $mn = static::getModel();
        $model = new $mn;

        $model->fill($request->all());
        $this->setSpecials($model, 'create');

        if (! $model->save())
            return redirect()->back()->withInput()->withErrors($model->errors());

        $this->afterSave($model, 'create');

        return redirect()->route(static::getRouteName('list'), $this->getRouteParams())->with(['message' => ['success', static::createSuccessfulMessage()]]);
    }

    public function EditModelForm() {
        try {
            return view(static::$editView)->with(array_merge($this->getViewParameters(), [
                'model' => static::getRequestedModel(),
            ]));
        } catch (ModelNotFoundException $e) {
            return redirect()->route(static::getRouteName('list'), $this->getRouteParams());
        }
    }

    public function EditModelStore(Request $request) {
        try {
            $model = static::getRequestedModel();

            $model->fill($request->all());
            $this->setSpecials($model, 'edit');

            if (! $model->save())
                return redirect()->back()->withInput()->withErrors($model->errors());

            $this->afterSave($model, 'edit');

            return redirect()->route(static::getRouteName('list'), $this->getRouteParams())->with(['message' => ['success', static::editSuccessfulMessage()]]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route(static::getRouteName('list'), $this->getRouteParams());
        }
    }

    public function RemoveModel() {
        try {
            $model = static::getRequestedModel();
            $model->delete();

            $this->afterDelete($model);

            return redirect()->route(static::getRouteName('list'), $this->getRouteParams())->with(['message' => ['success', static::deleteSuccessfulMessage()]]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route(static::getRouteName('list'), $this->getRouteParams());
        }
    }

    protected static function getRouteAddress($name) {
        $add = isset(static::$address[$name]) ? static::$address[$name] : $name;
        $add = "[single.en]/".$add;

        preg_match_all('/\[([^\]]+)\]/', $add, $matches);

        foreach ($matches[1] as $k => $name) {
            $chain = explode('.', $name);
            $var = static::getLanguageMap()[$chain[0]];

            while ($key = next($chain))
                $var = $var[$key];

            $add = preg_replace('/'.preg_quote($matches[0][$k]).'/', $var, $add, 1);
        }

        return $add;
    }

    public static function getRouteName($name) {
        $temp = collect([static::getPluralEn(), $name]);

        if (static::$routeNamePrefix)
            $temp->prepend(static::$routeNamePrefix);

        return $temp->implode('.');
    }

    protected function getViewParameters()
    {
        return [
            'manager' => $this,
        ];
    }

    protected static function createSuccessfulMessage()
    {
        return static::getSingularFa().' جدید با موفقیت ثبت شد';
    }

    protected static function editSuccessfulMessage()
    {
        return static::getSingularFa().' با موفقیت ویرایش شد';
    }

    protected static function deleteSuccessfulMessage()
    {
        return static::getSingularFa().' با موفقیت حذف شد';
    }

    protected static function getModelById($id)
    {
        return call_user_func([static::getModel(), 'findOrFail'], $id);
    }

    protected function getModelPaginator()
    {
        return call_user_func([static::getModel(), 'paginate'], static::$modelPerPage);
    }

    protected function setSpecials($model, $mod)
    {

    }

    protected function afterSave($model, $mod) {

    }

    protected function afterDelete($model) {

    }

    public function getRouteParams()
    {
        return [];
    }

    public function getReturnAddress() {
        return '';
    }
}
