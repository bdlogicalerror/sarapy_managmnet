
{{--
/**
 * Author: Mahmudul Hasan <bdlogicalerror@gmail.com>
 * Date: 11/8/18
 * Time: 12:48 PM
 */
--}}
<html>
    <head>
        <style>
            body{
                margin: 10px;
                padding: 10px;
                background-color: grey;
                text-align: center;

            }
            .header{
                padding: 10%;
                box-shadow: 3px 2px 20px 20px #191616;
                text-align: center;
                height: 100%;
            }

            .header>h1{
                color: #007eff;
                font-weight: 600;

            }
            .text{
                border-radius: 10px;
                background-color:oldlace;
                border: none;
                width: 50%;
                height: 40px;
                font-weight: 200;
                font-size: 17px;
            }
            .submit{
                border-radius: 10px;
                background-color:green;
                border: none;
                height: 40px;
                font-weight: 200;
                font-size: 17px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>License Expired</h1>
            <h2>Enter your license key</h2>
            <form action="{{route('store_license')}}" method="post">
                <input type="text" name="key" class="text">
                <input type="submit" class="submit" value="Submit">
            </form>
            <span>
                <a href="http://www.gotisoft.com" target="_blank">GotiSoft</a>
                <br>
                Email: info@gotisoft.com
                <br>
                Mobile: 8801912409071
            </span>
        </div>
    </body>
</html>
