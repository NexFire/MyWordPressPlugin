<?php
$default_tab="all-sommeliers";
$tab=isset($_GET["tab"])?$_GET["tab"]:$default_tab;
?>
<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <nav class="nav-tab-wrapper">
        <a href="?page=add-sommelier" class="nav-tab <?php if($tab==="all-sommeliers"):?>nav-tab-active <?php endif; ?> ">All Sommeliers</a>
        <a href="?page=add-sommelier&tab=add-sommelier" class="nav-tab <?php if($tab==="add-sommelier"):?>nav-tab-active <?php endif; ?> ">Add Sommelier</a>
    </nav>
    <div class="tab-content">
        <?php 
            switch($tab):
                case "add-sommelier":
                    if(!current_user_can("manage_options")){
                        echo "<p>Nemáte oprávnění přidávat Sommeliéry</p>";
                    }
                    else{
                    ?>
                    <div id="formContainer" action="<?php echo plugins_url('handelingForm.php', __FILE__); ?>" method="post">
                            <div id="statusContainer">
                                <span id="statusText"></span>
                            </div>
                            <div class="row">
                                <div id="profileContainer">

                                    <label id="profileLabel" for="imageInput">
                                        <svg id="profileIcon" fill="#EAEAEA" width="100px" height="100px" viewBox="0 0 30.586 30.586" xmlns="http://www.w3.org/2000/svg">

                                            <g transform="translate(-546.269 -195.397)">
                                            
                                            <path d="M572.138,221.245a15.738,15.738,0,0,0-21.065-.253l-1.322-1.5a17.738,17.738,0,0,1,23.741.28Z"/>
                                            
                                            <path d="M561.464,204.152a4.96,4.96,0,1,1-4.96,4.96,4.966,4.966,0,0,1,4.96-4.96m0-2a6.96,6.96,0,1,0,6.96,6.96,6.96,6.96,0,0,0-6.96-6.96Z"/>
                                            
                                            <path d="M561.562,197.4a13.293,13.293,0,1,1-13.293,13.293A13.308,13.308,0,0,1,561.562,197.4m0-2a15.293,15.293,0,1,0,15.293,15.293A15.293,15.293,0,0,0,561.562,195.4Z"/>
                                            
                                            </g>
                                            
                                            </svg>
                                    </label>
                                    <input id="imageInput" style="display:none;"required="" type="file" name="profile_photo" accept="image/*" capture>
                                    <img id="profileImage" height="100px" width="100px" style="display: none;"/>
                                </div>
                                <div id="dataColumn" class="column">
                                    <div class="row">
                                        <label for="name">Jméno:</label>
                                        <input id="name" type="text" />
                                    </div>
                                    <div class="row">
                                        <label for="email">Email:</label>
                                        <input id="email" type="text" />
                                    </div>
                                    <div class="row">
                                        <label for="mobil">Mobil:</label>
                                        <input id="mobil" type="text" />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row" style="align-items: center;">
                                <label for="popis">Popis:</label>
                                <textarea id="popis" name="Text1" cols="40" rows="5" style="width:100%; "></textarea>
                            </div>
                            <button id="addSommelier">Přidat</button>
                        </div>
                    <?php
                    }
                    break;
                default:
                    echo "<p>Zde bude dabulka se sommeliéry</p>";
                    break;
            endswitch;
        ?>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>