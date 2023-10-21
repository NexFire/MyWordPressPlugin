var $j = jQuery.noConflict();
$j(document).ready(function() {
    $j('#publish').click(function() {
        var title = $j('#title').val();
        if (title === '') {
            alert('Je potřeba doplnit jméno Sommeliera');
            setTimeout(function() {
                $j('#publish').removeClass('button-primary-disabled');
                $j('#publishing-action .spinner').hide();
            }, 1);
            return false;
        }
    });
});
