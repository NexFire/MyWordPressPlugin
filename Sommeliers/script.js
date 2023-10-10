function previewProfileImage( uploader ) {   
    //ensure a file was selected 
    if (uploader.files && uploader.files[0]) {
        var imageFile = uploader.files[0];
        var reader = new FileReader();    
        reader.onload = function (e) {
            //set the image data as source
            
            //console.log(reader.readAsBinaryString(e.target.result));
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
    /*
    console.log($j("#formContainer").attr("action"));
    $j.ajax({
        url : "http://localhost:8080/wp-admin/admin-ajax.php",
        data : {
            action : 'save_arraybuffer',
            id:1,
        },
        method : 'POST', //Post method
        success : function( response ){ console.log(response) },
        error : function(error){ console.log(error) }
      })
      */
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
                /*
                reader.onload=async function(event){
                    var popis="";
                    if($j("#popis").val()){
                        popis=$j("#popis").val();
                    }
                    var binaryData=event.target.result;
                    console.log(binaryData);
                    var decoder = new TextDecoder("utf-8");
                    console.log(decoder.decode(new Uint8Array(binaryData)));
                    photo=binaryData;
                    console.log(photo);
                    var response=await fetch($j('#profileImage').attr('src'));
                    var data = await response.blob();
                    console.log("Ahoj");
                    console.log(data);
                    console.log("Ahoj");
                    console.log(binaryData.typeof)
                    //formData.append('arrayBuffer', data);

                    // Make an AJAX request to your server-side PHP script
                    fetch('/wp-admin/admin-ajax.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Handle the response from the server if needed
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                   console.log($j("#formContainer").attr("action"));
                    */
                   /*
                    $j.post(
                        'http://localhost:8080/wp-admin/admin-ajax.php', 
                        data:{
                            'action': 'save_arraybuffer',
                            'foobar_id':   123
                        }, 
                        function(response) {
                            console.log('The server responded: ', response);
                        }
                    );
                     
                }
                */
                //reader.readAsDataURL(inputE.prop("files")[0])
                //reader.readAsText(inputE.prop("files")[0])
                //reader.readAsArrayBuffer(inputE.prop("files")[0]);
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
    /*
    if(!empty){
        $j.ajax({
            type:"post",
            url:$j("#formContainer").attr("action"),
            data:{
                "name":"Lol",
                "email":"gok",
                "mobil":"mobil",
                "popis":"absolunni lopata",
                foto:photo
            },
            success:function(html){
                console.log(html);
                if(html["status"]==200){
                    displayInfo(true,html["message"]);
                }
                else{
                    displayInfo(false,html["message"]);
                }
            },
            statusCode:{
                500:function(){
                    console.log("Nope we have error");
                }
            }
        });
    }
    else{
        displayInfo(false,"Doplňte důležité informace");
    }
    */
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
        console.log("What the fuck happens to this");
        previewProfileImage( this );
    });
    $j("#profileImage").on("click",function(){
        $j("#imageInput").trigger("click");
    });
    $j("#addSommelier").on("click",postInfo);
    
});