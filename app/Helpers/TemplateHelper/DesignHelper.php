<?php

namespace App\Helpers\TemplateHelper;

use App\{Enums\CategoryType, Enums\PublishType, Models\User};
use Avatar;
use Exception;
use Illuminate\{Database\Eloquent\Model, Support\Facades\Route, Support\Facades\Http, Support\Str};
use Psr\{Container\ContainerExceptionInterface, Container\NotFoundExceptionInterface};

class DesignHelper
{
    /**
     * @param string $routeName
     * @return string
     */
    public static function isActive(string $routeName): string
    {
        return str_contains(request()?->fullUrl(), $routeName) ? ' active' : '';
    }

    /**
     * @param array $routePatterns
     * @return string
     */
    public static function isShow(array $routePatterns): string
    {
        $currentPath = request()?->path();
        foreach ($routePatterns as $routePattern) {
            if (request()->routeIs($routePattern.'*')) {
                return ' menu-open';
            }
        }

        return '';
    }

    /**
     * @param array $routePatterns
     * @return string
     */
    public static function isMenuActive(array $routePatterns): string
    {
        $currentPath = request()?->path();
        foreach ($routePatterns as $routePattern) {
            if (request()->routeIs($routePattern.'*')) {
                return ' active';
            }
        }
        return '';
    }

    /**
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getLanguage(): string
    {
        return session()?->get('locale') === 'ar' ? 'ar' : 'en';
    }

    /**
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getDirection(): string
    {
        return session()->get('locale') === 'ar' ? 'rtl' : 'ltr';
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getMenuDirectionBottom(): string
    {
        return session()->get('locale') === 'ar' ? 'bottom-end' : 'bottom-start';
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function checkMenuDirectionStart(): string
    {
        return session()->get('locale') === 'ar' ? 'left-start' : '"right-start';
    }

    /**
     * @param string|null $url
     * @return bool
     */
    public static function isURLGETWorking(?string $url): bool
    {
        if (is_null($url)) {
            return false;
        }

        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['port'])) {
            return true;
        }

        try {
            $response = Http::withHeaders(['Content-Type: application/json;charset=UTF-8'])
                ->withUserAgent("Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0")
                ->get($url);
        } catch (Exception $exception) {
            return false;
        }

        return $response->status() === 200;
    }

    /**
     * @param User $user
     * @return string
     */
    public static function createOneTimeUserAvatar(User $user): string
    {
        return self::createAvatar($user, 'avatar','name', 'users');
    }

    /**
     * @param Model $model
     * @param string $imageColumnName
     * @param string $nameColumn
     * @param string $folderName
     * @return string
     */
    public static function createAvatar(Model $model, string $imageColumnName, string $nameColumn, string $folderName): string
    {
        $avatar = \Avatar::create($model->{$nameColumn})->setBackground('#009ef7');
        $imageName = Str::random(20);
        $path = "$folderName/images/$imageName.png";
        $avatar->save(public_path($path));
        $model->{$imageColumnName} = asset($path);
        $model->save();
        return $model->{$imageColumnName};
    }

}
