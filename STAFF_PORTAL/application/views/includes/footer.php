<?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>
<footer id="footer" class="main-footer d-flex p-2 px-3 bg-white border-top ">
    <span class="copyright  my-auto mr-0">Copyright © <script>
        document.write(new Date().getFullYear())
        </script>
        <a href="http://parrophins.com/" target="_blank" rel="nofollow"><span class="title_green">School</span><span
                class="title_blue ">Phins</span>.</a> All rights reserved
    </span>
</footer>
<?php }?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/extras.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/shards-dashboards.1.0.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/scripts/app/app-blog-overview.1.0.0.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/forgotPassword.js" type="text/javascript"></script>
<!-- Auto select box-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.cookie.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?=base_url()?>assets/plugins/sweetalert/sweetalert2.0.js"></script>

<script type="text/javascript">
$('.loaderScreen').hide();
$(".nav-link, .page-item").click(function() {
    $('.loaderScreen').show();
});
$(".dropdown-toggle, .nav-tabs, .pagination").click(function() {
    $('.loaderScreen').hide();
});



var windowURL = window.location.href;
pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));

var x = $('a[href="' + pageURL + '"]');

x.addClass('active');
x.parent().addClass('active');
var y = $('a[href="' + windowURL + '"]');
y.addClass('active');
y.parent().addClass('active');
var idi =x.parent();


$(".collapse").click(function() {
   sessionStorage.setItem("selected_nav", $(this).attr('id'));
});
let selected_nav = sessionStorage.getItem("selected_nav");
$('#'+selected_nav).addClass('show');
    // $(function() {
    //     $(this).bind("contextmenu", function(e) {
    //         e.preventDefault();
    //     });
    // }); 
    $(document).keydown(function(e){
        if(e.which === 123){
            return false;
        }
    });


    
</script>

</main>
</body>

</html>