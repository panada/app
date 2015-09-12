<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hello <?=$name?></title>
<link rel="stylesheet" href="<?=$this->uri->getAssetURI('assets/bundle/pure-min.css')?>">
<link rel="stylesheet" href="<?=$this->uri->getAssetURI('assets/bundle/combo.css')?>">
</head>
<body>
    <div id="main">
        <div class="header">
            <h1>Hello <?=$name?>!</h1>
            <h2>Panada has been installed successfully!</h2>
        </div>
        <div class="content">
            <p>This is sample page view. You can find this file at:</p>
            <pre class="code" data-language="html"><code><?=\Panada\Resource\Loader::$maps['Controller']?>view/index.php</code></pre>
            <p>The controller of this page is located at:</p>
            <pre class="code" data-language="html"><code><?=\Panada\Resource\Loader::$maps['Controller']?>Controller/Home.php</code></pre>
            <p>Base URI for this application is:</p>
            <pre class="code" data-language="html"><code><?=$this->uri->getBasePath()?></code></pre>
        </div>
    </div>
</body>
</html>