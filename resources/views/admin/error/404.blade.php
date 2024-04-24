<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        /*======================
        404 page
        =======================*/

        .page_404 {
            padding: 40px 0;
            background: #fff;
        }

        .four_zero_four_bg {
            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 380px;
            max-width: 100%;
            background-position: center;
            background-size: cover; /* Added property for setting width */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .four_zero_four_bg h1, .four_zero_four_bg h3 {
            font-size: 80px;
            color: #fff;
            margin: 0;
        }

        .contant_box_404 {
            text-align: center;
            margin-top: 30px;
        }

        .contant_box_404 h3 {
            font-size: 24px;
            margin: 10px 0;
        }

        .contant_box_404 p {
            font-size: 16px;
            margin: 10px 0;
        }

        .link_404 {
            color: #fff;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
            text-decoration: none;
        }
    </style>
    <title>404 Not Found</title>
</head>
<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <div class="four_zero_four_bg">
                            <h1>404</h1>
                        </div>
                        <div class="contant_box_404">
                            <h3>Looks like you're lost</h3>
                            <p>The page you are looking for is not available!</p>
                            <a href="{{route('welcome')}}" class="link_404">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
