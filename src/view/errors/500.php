<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Error 500 - Internal Server Error!</title>
<link rel="stylesheet" href="<?=$this->uri->getAssetURI('assets/bundle/pure-min.css')?>">
<link rel="stylesheet" href="<?=$this->uri->getAssetURI('assets/bundle/combo.css')?>">
</head>
<body>
    <div id="main">
        <div class="header">
            <h1>Error 500 Internal Server Error!</h1>
            <h2>The page you try to access is not available.</h2>
        </div>
        <?php if ( error_reporting() ): ?>
        <div class="content">
            <p>Here's an exception message:</p>
            <pre class="code" data-language="html"><code><?=$message?></code></pre>
            <p>Error in file:</p>
            <pre class="code" data-language="html"><code><?=$file?> Line: <?=$line?></code></pre>
            <p>Error code position:</p>
<pre class="code" data-language="php" style="line-height: 1"><code>
<?php foreach($code as $code): ?>
<?php echo $code;?>
<?php endforeach; ?>
</code></pre>
            <p>Backtrace info:</p>
            <pre class="code" data-language="html"><code><?=$trace?></code></pre>
        </div>
        <?php endif?>
    </div>
</body>
</html>