function previewProfileImage( uploader ) {   
    //ensure a file was selected 
    if (uploader.files && uploader.files[0]) {
        var imageFile = uploader.files[0];
        var reader = new FileReader();    
        reader.onload = function (e) {
            $j('#profileImage').attr('src', e.target.result);
            $j('#profileImage').css("display","block");
            $j("#profileIcon").css("display","none");
        }   
        reader.readAsDataURL( imageFile );
    }
}
function postInfo(){
    var empty=false;
    var inputs=$j("#formContainer input");
    var photo;
    const formData = new FormData();
    formData.append('action', 'save_arraybuffer');
    formData.append('nonce', dataObject.nonce);
    for(var a=inputs.length-1;a>=0 && !empty;a--){
        var inputE=$j('#'+inputs[a].id);
        if(!inputE.val()){
            displayInfo(false,"Doplňte důležité informace");
        }
        else{

            if(inputE.attr("type")=="file"){
                formData.append('file',$j("#imageInput").prop('files')[0]);
                var reader= new FileReader();
            }
            else{
                console.log(inputE.prop('id'));
                formData.append(inputE.prop('id'),inputE.val());
            }
        }
    }
    var popis="";
    if($j("#popis").val()){
        popis=$j("#popis").val();
    }
    else{
        popis="";
    }
    formData.append("popis",popis);
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data["status"]==200){
            displayInfo(true,data["message"]);
        }
        else{
            displayInfo(false,data["message"]);
        }
        // Handle the response from the server if needed
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayInfo(success,message){
    if(success){
        $j("#statusContainer").css("display","block");
        $j("#statusContainer").css("border-color","green");
        $j("#statusText").text(message);
        $j("#statusContainer").addClass("statusSuccessFull");
        setTimeout(function(){
            $j("#statusContainer").addClass("statusSuccess");
            $j("#statusContainer").removeClass("statusSuccessFull");
        },50);
        setTimeout(function(){
            $j("#statusContainer").css("display","none");
            $j("#statusContainer").removeClass("statusSuccess");
        },3500);

    }
    else{
        $j("#statusContainer").css("display","block");
        $j("#statusContainer").css("border-color","red");
        $j("#statusText").text(message);
        $j("#statusContainer").addClass("statusErrorFull");
        setTimeout(function(){
            $j("#statusContainer").addClass("statusError");
            $j("#statusContainer").removeClass("statusErrorFull");
        },50);
        setTimeout(function(){
            $j("#statusContainer").css("display","none");
            $j("#statusContainer").removeClass("statusError");
        },3500);
    }
}

$j(document).ready(function(){
    $j("#imageInput").change(function(){
        previewProfileImage( this );
    });
    $j("#profileImage").on("click",function(){
        $j("#imageInput").trigger("click");
    });
    $j("#addSommelier").on("click",postInfo);
    
});
