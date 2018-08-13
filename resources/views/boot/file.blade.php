<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>文件上传</title>
        <!--引入CSS-->
        <link rel="stylesheet" type="text/css" href="../../../vendor/webuploader/webuploader.css">

        <!--引入JS-->
        <script type="text/javascript" src="../../../vendor/webuploader/webuploader.js"></script>
        <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
    <div class="container"></div>
        <div class="container">
            <form action="/file/upload" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="file">File input</label>
                    上传文件<input type="file" name="myfile"/>
                </div>
                <input type="submit" value="上传"/>
            </form>
        </div>
    </body>

</html>