<?php

namespace Korkz\KorkzRouter;

class router
{
    protected static array $ENV = [];

    /**
     * @param array $ENV
     */
    public function __construct(array $ENV)
    {
        self::$ENV = $ENV;
    }

    protected function fileExtension($file): mixed
    {
        @$ext = pathinfo($file);
        return @$ext['extension'];
    }

    protected function change($url): string|array
    { // url yapısında  uzantı varsa siler

        $extension = $this->fileExtension($url);

        if ($extension) {
            $result = str_replace('.' . $extension, '', $url);

        } else {
            $result = $url;
        }

        return $result;

    }

    /**
     * @param $aim
     * @return array|string
     */
    private function aim($aim): array|string
    {
        $constantsAim = str_replace("[\"", "", $aim);
        $constantsAim = str_replace("\"]", "", $constantsAim);
        return str_replace("\"", "", $constantsAim);
    }

    public function router($requestUrl, string $control = ""): bool|array|string
    {
        $env = self::$ENV;
        $controlEnv = $env["CONSTANTS_CONTROL"];
return        $aim=explode(",",self::aim($env["CONSTANTS_AIM"]));

        $urlRequest = $this->change($requestUrl);
        $url = rtrim($urlRequest, "/");
        $url = ltrim($url, "/");
        $pathRoot = $_SERVER["DOCUMENT_ROOT"];
        $hostName = $env["HOST_NAMES"]; // env den host kurulu olduğu dosya alınıyor
        $hostUrl = $_SERVER["REQUEST_SCHEME"] . "://$hostName";
        if ($_SERVER["HTTP_HOST"] !== $env["CONSTANTS_HOST"]) { // local de gerçekleşen işlemler
            $path = ltrim(str_replace("$hostUrl/", "", $url), "/");
        } else { // hosta gerçekleşen işlemler
            $path = ltrim(str_replace("$hostName", "", $url), "/");
        }
        $path = rtrim($path, "/");
        $path = str_replace("$hostUrl", "", $path);
        $pathCount = substr_count($path, "/");
        if ($pathCount > 1) {
            $slash = str_repeat("/", $pathCount);
            $path = str_replace("$slash", "/", $path);
        }
        if ($control !== "$controlEnv") {
            return $constantsAim;
            return $constantsAim = explode(",", $constantsAim);
            if (!str_contains($path, $constantsAim)) { // home tarafı işlemler
                return "home";
                if (empty($path)) {
                    $path = "index";
                }
                if ($_SERVER["HTTP_HOST"] === $env["CONSTANTS_HOST"]) {
                    $localPath = "$pathRoot/$hostName";
                } else {
                    $localPath = $pathRoot;
                }
                $location = "home";
            } else { // admin tarafı işlemler
                return "admin";
                $path = str_replace("admin", "", $path);
                if (empty($path)) {
                    $path = "index";
                }
                $path = ltrim($path, "/");
                $path = rtrim($path, "/");
                if ($_SERVER["HTTP_HOST"] === $env["CONSTANTS_HOST"]) {
                    $localPath = "$pathRoot/$hostName";
                } else {
                    $localPath = $pathRoot;
                }
                $location = "admin";

            }
            if (str_contains($path, "/")) { // url içersinde bilgi alınması gerekıyorsa parçalanacak
                $explode = explode("/", $path);
                $path = $explode[0];
                $getAttribute = $explode[1];
            } else {
                $getAttribute = "";
            }
            if ($location !== "admin") {
                $pathDir = "$localPath/pages/home/$path.php";
            } else {
                $pathDir = "$localPath/pages/admin/$path.php";
            }
            if (!file_exists("$pathDir")) {
                if ($_SERVER["HTTP_HOST"] === $env["CONSTANTS_HOST"]) {
                    $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . "/$hostName/404";
                } else {
                    $url = $_SERVER["REQUEST_SCHEME"] . "://$hostName/404";
                }
                header("Location:$url");
            }
            $pathResult = ["path" => "$pathDir", "location" => $location, "pages" => $path, "getAttribute" => $getAttribute];
            return json_encode($pathResult);
        } else {
            if ($_SERVER["HTTP_HOST"] === $env["CONSTANTS_HOST"]) {
                $localPath = "$pathRoot/$hostName";
            } else {
                $localPath = $pathRoot;
            }

            return "$localPath/$controlEnv/$path";
        }

    }

}