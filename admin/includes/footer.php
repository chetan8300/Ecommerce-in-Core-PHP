</div>

<!-- Footer -->
<footer class="text-center" id="footer">&COPY; Copyright 2016 Gift Wrapper</footer>
<script>
    
    function updateSizes(){
        var sizeString = ''; 
        for(var i=1;i<=10;i++){
            if(jQuery('#size'+i).val() != ''){
                sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
            }
        }
        var size = sizeString.slice(0, sizeString.lastIndexOf(","));
        jQuery('#sizes').val(size);
    }
    
    function get_child_options(){
        jQuery.ajax({
            url: '/ecommerce/admin/parsers/child_categories.php',
            type: 'POST',
            data: {'id': jQuery('#parent').val()},
            success: function(data){
                jQuery('#child').html(data);
            },
            error: function(){
                alert("Something went wrong with child option.");
            }
        });
    }
    jQuery('select[name="parent"]').change(get_child_options);
    
</script>
</body>
</html>