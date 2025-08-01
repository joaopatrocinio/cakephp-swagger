<?php

use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\UrlHelper;

if (empty($uiConfig['title'])) {
    $uiConfig['title'] = "cakephp-swagger";
}

if (!isset($uiConfig['validator'])) {
    $uiConfig['validator'] = true;
}

if (!isset($uiConfig['api_selector'])) {
    $uiConfig['api_selector'] = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $uiConfig['title'] ?></title>
    <?php

    // favicons
    echo $this->Html->meta([
        'link' => $this->Url->assetUrl('Cstaf/Swagger./images/favicon-32x32.png', ['fullBase' => true]),
        'rel' => 'icon',
        'sizes' => '32x32',
        'type' => 'image/png',
    ]);
    echo $this->Html->meta([
        'link' => $this->Url->assetUrl('Cstaf/Swagger./images/favicon-16x16.png', ['fullBase' => true]),
        'rel' => 'icon',
        'sizes' => '16x16',
        'type' => 'image/png'
    ]);

    // screen stylesheets
    echo $this->Html->css([
        'Cstaf/Swagger.typography.css',
        'Cstaf/Swagger.reset.css',
        'Cstaf/Swagger.screen.css',
    ], ['media' => 'screen', 'once' => false, 'fullBase' => true]);

    // print stylesheet
    echo $this->Html->css([
        'Cstaf/Swagger.reset.css',
        'Cstaf/Swagger.print.css',
    ], ['media' => 'print', 'once' => false, 'fullBase' => true]);

    // javascript libraries
    echo $this->Html->script([
		'Cstaf/Swagger./lib/object-assign-pollyfill.js',
        'Cstaf/Swagger./lib/jquery-1.8.0.min.js',
        'Cstaf/Swagger./lib/jquery.slideto.min.js',
        'Cstaf/Swagger./lib/jquery.wiggle.min.js',
        'Cstaf/Swagger./lib/jquery.ba-bbq.min.js',
        'Cstaf/Swagger./lib/handlebars-4.0.5.js',
        'Cstaf/Swagger./lib/lodash.min.js',
        'Cstaf/Swagger./lib/backbone-min.js',
        'Cstaf/Swagger./swagger-ui.js',
        'Cstaf/Swagger./lib/highlight.9.1.0.pack.js',
        'Cstaf/Swagger./lib/highlight.9.1.0.pack_extended.js',
        'Cstaf/Swagger./lib/jsoneditor.min.js',
        'Cstaf/Swagger./lib/marked.js',
        'Cstaf/Swagger./lib/swagger-oauth.js'
    ], ['fullBase' => true]);

    ?>

    <!-- Some basic translations -->
    <!-- <script src='lang/translator.js' type='text/javascript'></script> -->
    <!-- <script src='lang/ru.js' type='text/javascript'></script> -->
    <!-- <script src='lang/en.js' type='text/javascript'></script> -->

    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "<?= $url ?>";
            }

			hljs.configure({
				highlightSizeThreshold: 5000
			});

            // Pre load translate...
            if(window.SwaggerTranslator) {
                window.SwaggerTranslator.translate();
            }
            window.swaggerUi = new SwaggerUi({
                url: url,
                <?php if ($uiConfig['validator'] === false) : ?>
                    validatorUrl: false,
                <?php endif ?>
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                onComplete: function(swaggerApi, swaggerUi){
                    if(typeof initOAuth == "function") {
                        initOAuth({
                            clientId: "your-client-id",
                            clientSecret: "your-client-secret-if-required",
                            realm: "your-realms",
                            appName: "your-app-name",
                            scopeSeparator: ","
                        });
                    }

                    if(window.SwaggerTranslator) {
                        window.SwaggerTranslator.translate();
                    }
                },
                onFailure: function(data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none",
                jsonEditor: false,
                defaultModelRendering: 'schema',
                showRequestHeaders: false
            });

            window.swaggerUi.load();

            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }
        });
    </script>
</head>

<body class="swagger-section">
<div id='header'>
    <div class="swagger-ui-wrap">
        <a id="logo" href="http://swagger.io">swagger</a>
        <?php if ($uiConfig['api_selector'] === true) : ?>
            <form id='api_selector'>
                <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
                <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
                <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
            </form>
        <?php endif; ?>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
</body>
</html>
