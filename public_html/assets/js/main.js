var roboarm = document.getElementById('roboarm');
var sign = document.getElementById('signUpBoard');
var arrow = document.getElementById('arrow');
var BB8 = document.getElementById('BB8');
var scrolledOnce = false;

window.onload = function() {
    $window = $(window);
    var width = $window.width();
    console.log(width);
    if(width > 430)
    {
        roboarm.classList.add("animate");
        TweenMax.to("#arm", 1, {
            rotation: 17,
            delay: 4,
            transformOrigin: "20px 264px",
            onComplete: myCallback
        });

        $window.scroll(function(){
            if(isScrolledIntoView("#BB8") && !scrolledOnce) {
                TweenMax.to("#roller", 1, {
                    rotation: 360,
                    transformOrigin: "50% 50%",
                    ease:Linear.easeNone,
                    repeat: -1
                });

                TweenMax.to("#BB8", 3, {
                    css:{left: width-100},
                    ease: Linear.easeNone
                });
                setTimeout(myCallback, 3000);
                scrolledOnce = true;
            }
        });
    }
    else {
        TweenMax.to("#arm", 1, {
            rotation: 17,
            delay: 1,
            transformOrigin: "20px 264px"
        });

        TweenMax.to("#roller", 1, {
            rotation: 360,
            transformOrigin: "50% 50%",
            ease:Linear.easeNone,
            repeat: -1
        });
    }




    new WOW().init();
}

function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemTop = $(elem).offset().top;
    return ((elemTop <= docViewBottom) && (elemTop >= docViewTop));
}

function myCallback() {
    TweenMax.killTweensOf('#roller');
    $('#BB8').css('transform', 'translateX(-235px) scaleX(-1)');
}


// Prevent reloading on submiit


$(document).ready(function(){
    $(".form-inline").submit(function(event){
        event.preventDefault();

        var name = $("#subscribe-name").val();
        var email = $("#subscribe-email").val();
        var id = $("#subscribe-id").val();
        var dept = $("#subscribe-dept").val();
        var phone = $("#subscribe-phone").val();
        var batch= $("#subscribe-batch").val();

        $(".form-message").load("register.php", {

            email: email,
            name: name,
            id: id,
            dept: dept,
            phone: phone,
            batch: batch

        });


    });

    $(".news-form").submit(function(event){
        event.preventDefault();

        var em = $("#newsletter-email").val();
        console.log(em);

        $(".newsletter-message").load("newsletter.php", {

            email: em

        });


    });
});
