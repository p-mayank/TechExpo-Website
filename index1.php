<?php
$message="";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$target_dir = '../uploads/'+$_POST['name']+'/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$message="";
$upload_ok = 1;
$file_type = pathinfo($target_file, PATHINFO_EXTENSION);

if(file_exists($target_file)) {
    $message= 'File already exists!';
    $upload_ok=0;
}

/*if($_FILES['file']['size']>500000)
{
    echo 'File size is too large';
    $upload_ok = 0;
}*/

if($file_type!='pdf'){
    $message= 'Sorry, only pdf files are allowed';
    $upload_ok = 0;
}

if($upload_ok != 0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        $message= 'Your file '. basename($_FILES["file"]["name"]).' has been saved.';
    }
    else{
    $message= "There was an error handling your file.";
}
}
else{
    $message= "There was an error handling your file.";
}

/*require_once('../techexpo/PHPMailer-master/class.phpmailer.php');*/
require '../techexpo/PHPMailer-master/PHPMailerAutoLoad.php';
require '../techexpo/PHPMailer-master/class.smtp.php';


$email = new PHPMailer();
$email->SMTPDebug = 2;
$email->Host = 'smtp.gmail.com';
$email->SMTPSecure = 'tls'; 
$email->Port = 587;
$email->SMTPAuth = true;
$email->Username = '*******@gmail.com';
$email->Password = '********';
$email->isHTML(false);
$email->setFrom($_POST['email'], $_POST['name']);
$email->Subject   = 'Team detail submission[NEW]';
$email->Body      = $_POST['message'].'<br>'.$_POST['select'];
$email->AddAddress( 'er.mayank96@gmail.com' );

$file_to_attach = $target_file;

$email->AddAttachment( $file_to_attach , $_POST['name']+'.pdf' );

if(!$email->send()) 
{
    $message= "Mailer Error: " . $email->ErrorInfo;
} 
else 
{
    $message= "Message has been sent successfully";
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TechExpo</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css" />

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Theme CSS -->
    <link href="css/agency.min.css" rel="stylesheet">
    <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
    <style>
    .btn-file {
    position: relative;
    overflow: hidden;
}

.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;}

.text {
  background-color: #fed136;
  color: black;
  font-size: 16px;
  border-radius: 2px;
  padding: 10px 10px;
}
.team-member {
}

#image1 {
  opacity: 1;
  display: block;
  height: auto;
  transition: .5s ease;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -200%);
  -ms-transform: translate(-50%, -50%)
}

.team-member:hover #image1 {
  opacity: 0.3;
}

.team-member:hover .middle {
  opacity: 1;
}

#linkk{

    transition: transform 0.5s ease;
}

#hrefl:hover #linkk{
    transform: rotate(360deg);}

#leftc.start {
    animation-name: leftfly;
    animation-duration: 1s;
    animation-timing-function: ease-out;
    animation-delay: 0.5s;
    animation-fill-mode: both;
}

@keyframes leftfly{
    0% {
    opacity: 0;
    transform: translateX(-2000px);
  }

  60% {
    opacity: 1;
    transform: translateX(30px);
  }

  80% {
    transform: translateX(-10px);
  }

  100% {
    transform: translateX(0);
  }
}

#rightc.start {
    animation-name: rightfly;
    animation-duration: 1s;
    animation-delay: 0.5s;
    animation-timing-function: ease-out;
    animation-fill-mode: both;
}

@keyframes rightfly{
    0% {
        opacity: 0;
        transform:translateX(2000px);
    }

    60% {
        opacity: 1;
        transform: translateX(-30px);
    }

    80%{
        transform: translateX(10px);
    }

    100%{
        transform: translateX(0px);
    }
}


</style>
    <script>

    function isElementInViewport(elem) {
    var $elem = $(elem);

    // Get the scroll position of the page.
    var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewportTop = $(scrollElem).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    // Get the position of the element on the page.
    var elemTop = Math.round( $elem.offset().top );
    var elemBottom = elemTop + $elem.height();

    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
}

// Check if it's time to start the animation.
function checkAnimation() {
    var $elem = $('#leftc');

    // If the animation has already been started
    if ($elem.hasClass('start')) return;

    if (isElementInViewport($elem)) {
        // Start the animation
        $elem.addClass('start');
    }else{
        $elem.removeClass('start');
    }
}

function checkAnimationRight() {
    var $elem = $('#rightc');

    // If the animation has already been started
    if ($elem.hasClass('start')) return;

    if (isElementInViewport($elem)) {
        // Start the animation
        $elem.addClass('start');
    }else{
        $elem.removeClass('start');
    }
}



// Capture scroll events
$(window).scroll(function(){
    checkAnimation();
    checkAnimationRight();
});
    
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index" style="background-color: black;">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="margin-top: 20px;">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"><img src="img.png" style="max-width: 100%;
    width: 50%;""></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" style="margin-top: 18px; margin-bottom: 18px;">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#Benefits">Benefits</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#cat">Categories</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#Registration">Registration</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Previous Judges</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#reviews">Reviews</a>
                    </li><!--
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    

    <!-- Header -->
    <header style="
            position: relative;
            z-index: 0;">
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in"></div>
                <div class="intro-heading">TechExpo 2017</div>
                <a href="#About" class="page-scroll btn btn-xl">Tell Me More</a>
            </div>
        </div>
        <div class="wrapper-bottom" style="position: absolute;top:0;height: 100%; width: 100%;z-index: -1;
        background-image: url(../techexpo/img/header-bg4.jpg);background-repeat:no-repeat;background-attachment:scroll;background-position:center center;-webkit-background-size:cover;-moz-background-size:cover;background-size:cover;-o-background-size:cover;text-align:center;">
        </div>
        
    </header>

    <!-- About Section -->
    <section id="About" style="background-color: white;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">What is TechExpo?</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12 text-center">
                    <h4 class="service-heading" style="    font-weight: 400;     word-spacing: 3px;"><strong>TechExpo</strong> is the annual project showcasing event hosted by Techniche, the techno-management fest of IIT Guwahati. It has been initiated with the sole purpose of bringing to light the technological advancements made by the youth of this country. It provides a platform for the participants to showcase their projects in front of a mass multitude of people which includes renowned Professors, notable personage like Nobel Laureates and also students from the all across the nation.</h4>
                    <p class="text-muted"></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Grid Section -->
    <section id="Benefits" class="bg-light-gray" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">What’s in it for me?</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12 text-center">
                    <h4 class="service-heading" style="    font-weight: 400;     word-spacing: 3px;">The biggest problem any project faces for the “next big step” is funding, and because of which, to ensure that innovations worth spreading receive whatever is necessary, has always been our motto.</h4> 
                    <h4 class="service-heading" style="    font-weight: 400;     word-spacing: 3px;">Don’t believe us? Last year, <strong>cash prizes of Rs.3 Lakhs</strong> were given to top contenders.</h4> 

                    <h4 class="service-heading" style="    font-weight: 400;     word-spacing: 3px;">Ranked amongst the top universities in India with its breathtaking scenery and natural beauty, IIT Guwahati provides the perfect atmosphere for a scientific getaway. Not to mention Techniche also plays host to a number of speakers from varied fields, and has had honoured guests who are internationally acclaimed during the span of the event.( For the list of speakers that attended Techniche’16, <a href="#team">click here</a>.)<br><br><br><br><br><br><br><br></h4>
                </div>
            </div>
            
    </div>
    </section>
    <section id="cat" style="background-color: white;">
        <div class="container">

    <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Any categories?<br><br></h2>
                    <h3 class="section-subheading text-muted">Yes, definitely. In this edition of Techexpo, to further enhance the experience, there will be 2 independent categories.</h3>
                </div>
            </div>
<div class="card" id="leftc">

    <!--Card image-->
    <img class="img-fluid" src="../techexpo/img/low.jpg" width="60%" alt="Card image cap" style="border-radius: 8px;">
    <!--/.Card image-->

    <!--Card content-->
    <div class="card-block">
        <!--Title-->
        <h3 class="card-title">Backyard Boffins</h3>
        <!--Text-->
        <p class="card-text" style="width: 60%;     font-family: Montserrat,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size: 17px;">The <strong>Backyard Boffins</strong>  category is where amazing high school students with an unquenchable thirst for science display their projects/models. So if you are a high school student or team with a project worth sharing this is the category for you. <br><br><br><br><br><br></p>
        <!--<a href="#" class="btn btn-primary">Button</a>-->
    </div>
    <!--/.Card content-->

</div>
<!--/.Card-->
<div class="row">
<div class="col-md-11 col-md-offset-5">
<div class="card" id="rightc">

    <!--Card image-->
    <img class="img-fluid" src="../techexpo/img/adv.jpg" width="60%" alt="Card image cap" style="border-radius: 8px;">
    <!--/.Card image-->

    <!--Card content-->
    <div class="card-block">
        <!--Title-->
        <h3 class="card-title">Elite Innovators</h3>
        <!--Text-->
        <p class="card-text" style="width: 60%;     font-family: Montserrat,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size: 17px;">The <strong>Elite Innovators</strong> category is the advanced category where people with projects worth sharing ,from different institutes all across the nation, display them on a head to head battle for glory. The only criteria is that the age limit is up to 29 years only. </p>
        <!--<a href="#" class="btn btn-primary">Button</a>-->
    </div>
    <!--/.Card content-->

</div>
<!--/.Card-->
</div>
</div>
</div>
</section>


    <!-- About Section -->
    <section id="Registration" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Registration</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h3 class="service-heading" style="    font-weight: 400;     word-spacing: 3px;">You can <strong>REGISTER</strong> here!<br><br>
</h3>

                    <h4 class="service-heading" style="    font-weight: 500;     word-spacing: 3px;">All you have to do is submit a detailed sketch
of your project and a video (optional) which will undergo a preliminary round of screening after which the selected teams will get the opportunity to showcase their projects during the event at IIT Guwahati.</h4><br><br><br>
                    <p class="text-muted"></p>
                
            <?php if($message!=""){?>
            <h4 class="service-heading" style="font-weight: 500;word-spacing: 3px;color: #3dae35"><?php echo $message;?></h4><br><br><br><?php }?>
            </div>
            </div>
            <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                        <div class="row text-center">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Team Name" id="name" name="name" required data-validation-required-message="Please enter your name." required="required">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Team Email" id="email" name="email" required data-validation-required-message="Please enter your email address." required="required">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Team Contact" id="phone" name="phone" required data-validation-required-message="Please enter your phone number." required="required">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="select" required="required">
                                        <option name="Backyard Boffins">Backyard Boffins</option>
                                        <option name="Elite Innovators">Elite Innovators</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Team VideoLink" id="message" data-validation-required-message="Please enter a link." name="message" row=1 ></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group"> <!--                       
                                <span class="btn btn-large btn-warning btn-file" style="    color: #fff;
    background-color: #4e4a44;
    border-color: #514e4e;
    line-height: 2;
    padding-left: 100px;
    padding-right: 100px;">
                                Choose File to Upload! (*.PDF)
                                </span>-->
                                
                                <div class="fileinput fileinput-new" data-provides="fileinput">
    <span class="btn btn-default btn-file"><span>Choose file to upload(*.pdf)</span><input type="file" required="required" name="file" /></span>
    <span class="fileinput-filename"></span><span class="fileinput-new"></span>
</div>
</div>
                            
                                
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-xl" style="line-height: 1;" name="submit">SUBMIT</button>
                            </div>
                        </div>
                    </form>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" style="background-color: white;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Previous Year Judges</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <h4 class="service-heading" style="    font-weight: 400;     word-spacing: 3px;">We make sure, every year, the participants get the opportunity to be judged by those who have excelled in their field of expertise and have them share their deep insight on the projects.</h4><br><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/1.png" class="img-responsive img-circle" id="image1" alt="">
                        <div class="middle">
                            <div class="text">Sachin Kumar
                            </div>
                        </div>
                        <h4>Sachin Kumar</h4>
                        <p class="text-muted">Associate Professor, Indian Institute of Technology Guwahati  ( Scientist/ Researcher in field of immunology)</p>
                        <!--
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/2.jpg" class="img-responsive img-circle" id="image1" alt="">
                        <div class="middle">
                            <div class="text">Frederick J. Raab
                            </div>
                        </div>
                        <h4>Frederick J. Raab</h4>
                        <p class="text-muted">Head, LIGO Hanford Observatory ( First Observatory to observe gravitational waves )</p>
                        <!--<ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/3.jpg" class="img-responsive img-circle" id="image1" alt="">
                        <div class="middle">
                            <div class="text">Amit Sethii
                            </div>
                        </div>
                        <h4>Amit Sethii</h4>
                        <p class="text-muted">Assistant Professor, Indian Institute of technology Guwahati( Educator and Scientist in Electrical Engineering)</p>
                        <!--
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="team-member">
                        <img src="img/team/4.jpg" class="img-responsive img-circle" id="image1" alt="">
                        <div class="middle">
                            <div class="text">Senthil Murugan
                            </div>
                        </div>
                        <h4>Senthil Murugan</h4>
                        <p class="text-muted">Associate Professor, Indian Institute of Technology Guwahati  ( researcher in field of water management )</p>
                        <!--<ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <p class="large text-muted"></p>
                </div>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="reviews" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Reviews</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/1.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Team Name</h4>
                                    <h4 class="subheading"></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Review1</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/2.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Team Name</h4>
                                    <h4 class="subheading"></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Review2</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/3.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Team Name</h4>
                                    <h4 class="subheading"></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Review3</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/4.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Team Name</h4>
                                    <h4 class="subheading"></h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Review4</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <h4>Be Part
                                    <br>Of Our
                                    <br>Story!</h4>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Sponsors -->
    <aside class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                <!--
                    <a href="#">
                        <img src="img/logos/envato.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/designmodo.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/themeforest.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/creative-market.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                -->
            </div>
        </div>
    </aside>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contact Us</h2>
                    <h3 class="section-subheading text-muted"></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-1">
                    <h4 class="section-heading" style="color: #dedada;">Arpit Mathur</h4>
                    <h4 class="section-heading" style="font-size: 17px"><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:+918473934459">   +918473934459</a> </h4> 
                </div>
                <div class="col-md-4">
                    <h4 class="section-heading" style="color: #dedada;">Arooshi Bajaj</h4>
                    <h4 class="section-heading" style="font-size: 17px"><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:+919815364046">   +919815364046</a> </h4> 
                </div>
                <div class="col-md-3">
                    <h4 class="section-heading" style="color: #dedada;">Nikhil Gnanavel</h4>
                    <h4 class="section-heading" style="font-size: 17px"><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:+918220363117">   +918220363117</a> </h4> 
                </div>
                <!--
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-xl">Send Message</button>
                            </div>
                        </div>
                    </form>
                    -->
                </div>
            </div>
        </div>
    </section>

    <footer style="background-color: white;">
        <div class="container" >
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; <a href="https://www.techniche.org" target="_blank">Techniche '17</a></span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="https://www.facebook.com/techniche.iitguwahati/?fref=ts" target="_blank" id="hrefl"><i class="fa fa-facebook" id="linkk"></i></a>
                        </li>
                        <li><a href="https://twitter.com/techniche_iitg" target="_blank" id="hrefl"><i class="fa fa-twitter" id="linkk"></i></a>
                        </li>
                        <li><a href="https://www.instagram.com/techniche/" target="_blank" id="hrefl"><i class="fa fa-instagram" id="linkk"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-envelope" aria-hidden="true"></i><span class="copyright"><a href="mailto:techexpo@techniche.org" style="color:#333;">  Contact Us</a></span>
                </div>
                <!--
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>-->
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/agency.min.js"></script>
    <script type="text/javascript">

        $(window).load(function(){
            var k = 0;
            function SlideShow(){
            k+=1
            console.log(k);
            $('.wrapper-bottom').fadeOut(1000, function(){
                $(this).css({'background-image':'url(../techexpo/img/header-bg'+k+'.jpg)'});}).fadeIn(1000);


            if(k==4){
                k=k%4;
            }
            }
            setInterval(SlideShow, 7000);
        });
    </script>

</body>

</html>
