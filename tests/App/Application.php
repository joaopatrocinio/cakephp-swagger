<?php
declare(strict_types=1);

namespace Cstaf\Swagger\Test\App;

use Cstaf\Swagger\Plugin;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

class Application extends BaseApplication
{
    /**
     * Loads the assets and routing middleware which are necessary to test the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to set in your App Class
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware($middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Handle plugin/theme assets like CakePHP normally does.
            ->add(AssetMiddleware::class)
            // Add routing middleware.
            ->add(new RoutingMiddleware($this, null));

        return $middlewareQueue;
    }

    public function bootstrap(): void
    {
        $this->addPlugin(Plugin::class, ['routes' => true, 'bootstrap' => true]);
        parent::bootstrap();
    }
}
