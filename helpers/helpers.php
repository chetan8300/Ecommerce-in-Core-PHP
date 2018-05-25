<?php 
    function display_errors($errors){
        $display = '<ul class="bg-danger">';
        foreach($errors as $error){
            $display .= '<li class="text-danger">'.$error.'</li>';
        }
        $display .= '</ul>';
        return "<b>".$display."</b>";
    }
    
    function display_success($success){
        $display = '<ul class="bg-success">';
        $display .= '<li class="text-danger">'.$success.'</li>';
        $display .= '</ul>';
        return "<b>".$display."</b>";
    }
    
    function sanitize($dirty){
        return htmlentities($dirty,ENT_QUOTES,"UTF-8");
    }
    
    function money($money){
        return '$'.number_format($money,2);
    }
    
    
    function get_category($child_id){
        global $db;
        $id = sanitize($child_id);
        $sql = "SELECT p.id AS 'pid', p.category AS 'parent', c.id AS 'cid', c.category AS 'child' 
                FROM categories c
                INNER JOIN categories p
                ON c.parent = p.id
                WHERE c.id = '".$id."'";
        $childRefer = $db->query($sql);
        $category = mysqli_fetch_assoc($childRefer);
        return $category;
    }
    
    function sizesToArray($string){
        $sizesArray = explode(',',$string);
        $returnArray = array();
        foreach($sizesArray as $size){
            $s = explode(':',$size);
            $returnArray[] = array('size'=>$s[0], 'quantity'=>$s[1]);
        }
        return $returnArray;
    }
    
    function sizesToString($sizes){
        $sizeString = "";
        foreach ($sizes as $size){
            $sizeString .= $size['size'].':'.$size['quantity'].',';
        }
        $trimmed = rtrim($sizeString,',');
        return $trimmed;
    }