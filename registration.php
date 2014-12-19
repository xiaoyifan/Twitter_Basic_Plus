<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>database-TBP project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Loading Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
        <!-- Loading Flat UI -->
        <link href="css/flat-ui.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/favicon.ico">
        
        <!-- Loading datepicker -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
        
        <style type="text/css">
        html,body{
            background: #f5f5f5;
            margin:0px;
            padding: 0px;
            height: 100%;
            width: 100%;
        }
        .body{
            margin: 0 auto;
            max-width: 970px;
            margin-top: 20px;
            border: 1px solid #ccc;
            box-shadow:  0 5px 20px #ccc;
            min-height: 900px;
        }
        .container,.row{
            padding-top:30px;max-width:960px;
            margin:0px;
        }
        .span6{
            border-left: 3px solid #e7e9ec;
        }
        .right{
            text-align: right;
        }
        .span6 .row{
            padding-top: 0px;
        }
        .span2{
            text-align: right;
        }
        .to{
            text-align: center;
        }
        .float{
            float: left;
            margin-right: 10px;

        }
        .table{

            background: white;
        }
        .light{
            height: 12px;
            width: 12px;
            border-radius: 12px;
        }
        .input-xlarge{
            width: 300px;
        }
        .find-distribute{
            display: none;
        }
        table{
            width: 100%;
        }
        th{
            font-size: 15px;
            font-family: helvetica;
        }
        td{
            font-size: 14px;
        }
        legend{
            margin-left: 20px;
            width: 96%;
        }
        </style>
    </head>
<body>
    <div class="body">
        <div class="container">
            <div class="navbar navbar-inverse">
                    <ul class="nav" style="padding-left: 10px">
                        
                        <li><p style="color:white"> Already have an account? </p></li>
                        <li>
                            <a href="Login.html">Login here</a>
                        </li>
                       
                    </ul>
            </div>
        </div>

        <legend>New user registration</legend>
      <form method=get action="regisDone.php">
        <div class="row">
            <div class="span1"></div>
            <div class="span2 right">User ID(E-Mail)</div>
            <div class="span6">
                <div class="row">
                    <div class="span5">
                        <input type="text" value="" placeholder="ID" class="input-sm form-control datePicker" name="email">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span1"></div>
            <div class="span2 right">User Name</div>
            <div class="span6">
                <div class="row">
                    <div class="span5">
                        <input type="text" value="" placeholder="User Name" class="input-sm form-control datePicker" name="name">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span1"></div>
            <div class="span2 right">Gender</div>
            <div class="span6">
                <div class="row">
                    <div class="span5">
                        <input type="text" value="" placeholder="Gender" class="input-sm form-control datePicker" name="sex">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span1"></div>
            <div class="span2 right">Intro</div>
            <div class="span6">
                <div class="row">
                    <div class="span5">
                        <input type="text" value="" placeholder="Intro" class="input-sm form-control datePicker" name="intro">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span1"></div>
            <div class="span2 right">password</div>
            <div class="span6">
                <div class="row">
                    <div class="span5">
                        <input type="text" value="" placeholder="password" class="input-sm form-control datePicker" name='password'>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span1"></div>
            <div class="span2 right">Date Of Birth</div>
            <div class="span6">
                <div class="row show-grid">
                    
                    <div class="span2">
                        <input type="text" value="" placeholder="Date of Birth" class="input-sm form-control datetimepick" name="dateofbirth">
                    </div>
                
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span1"></div>
            <div class="span2"></div>
            <div class="span6">
                <div class="span6">
                 
                   
                        <input class = "btn btn-success find-dis" type="submit" value="Submit">
                    
                
                </div>
            </div>
        </div>
      </form>    
    </div>

        <script src="js/jquery-1.8.3.min.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.js"></script>
        <script src="js/bootstrap-switch.js"></script>
        <script src="js/flatui-checkbox.js"></script>
        <script src="js/flatui-radio.js"></script>
        <script src="js/jquery.tagsinput.js"></script>
        <script src="js/jquery.placeholder.js"></script>
        <!-- datepicker -->
        <script type="text/javascript" src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("select").selectpicker({style: 'btn-sm btn-primary', menuStyle: 'dropdown-inverse'});
            $(".datetimepick").datetimepicker().on("changeDate",function(e){
                $(".datetimepicker ").hide();
            });
            
        });
        </script>  
    </body>
</html>