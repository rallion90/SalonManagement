<?php include("nav.php");?>
<br>
<div class="container text-center" style="font-family: Times New Roman;">
    <div class="mission">
        <h1>-Our Mission-</h1>
        <p>To Provide a beautiful haircut in order to achieve the customer goals.</p>
    </div>  
    <br>
    <div class="vision">
        <h1>-Our vision-</h1>
        <p>Salungat sa kaalaman ng marami, ang Lorem Ipsum ay hindi puro walang kwentang salita lang. Umuugat ito sa klasikong literatura na Latin galing 45 BC, Pinpahiwatig na higit 2000 na ang taong gulang nito. Si Richard McClintock, isang Latin na propesor sa Hampden-Sydney College sa Viginia, ay hinanap ang isa sa mga tagong salita sa Latin, consectetur, galing sa talata ng Lorem Ipsum, at papunta sa mga siyudad sa mundo sa klasikal na literatura, natuklasan ang walang kadudadudang pinanggalingan. Ang Lorem Ipsum ay nangagaling sa mga seksyon 1.10.32 at 1.10.33 ng "de Finibus Bonorum et Malorum" (Ang Kasukdulan ng Mabuti at Masama) ni Cicero, isinulat noong 45 BC. Ang librong ito ay isang treatise sa teorya ng etika, tanyag noong Renaissance. Ang unang linya ng Lorem Ipsum, "Lorem ipsum dolor sit amet..", ay galing sa linya ng sekyon 1.10.32
        Ang regular na tipak ng Lorem Ipsum na ginamit mula pa noong 1500s ay kinopyo sa ibaba para sa mga intersado. Ang mga sekyon na 1.10.32 at 1.10.33 galing sa "de Finibus Bonorum et Malorum" ni Cicero ay kinopya sa eksakton orihinal na porma, kasama ang Ingles na bersyion galing sa 1914 na pagsasalin ni H. Rackham.</p>
    </div>     
</div>

<hr>

<div class="container">
    <div class="row " style="margin-top: 50px">
        <div class="col-md-12 form-container">
            <h2 class="text-center">Feedback</h2>
            <p>
                Please provide your feedback below:
            </p>
            <form role="form" method="post" id="reused_form">
                
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="comments">
                            Comments:</label>
                        <textarea class="form-control" type="textarea" name="comments" id="comments" placeholder="Your Comments" maxlength="6000" rows="7"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="name">
                            Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="email">
                            Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                            <div class="row">
                    <div class="col-sm-12 form-group">
                        <button type="submit" class="btn btn-lg btn-warning btn-block" >Post </button>
                    </div>
                </div>

            </form>
            <div id="success_message" style="width:100%; height:100%; display:none; ">
                <h3>Posted your feedback successfully!</h3>
            </div>
            <div id="error_message"
                    style="width:100%; height:100%; display:none; ">
                        <h3>Error</h3>
                        Sorry there was an error sending your form.
            </div>
        </div>    
    </div>
</div>   



<?php include('footer.php');?>