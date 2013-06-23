<div id="content" class="box">   
      <input type="hidden" id="uid" value="">
      <input type="hidden" id="str_addr" value="<?php echo $_SERVER ['QUERY_STRING'];?>">
      <input type="hidden" id="db_n" value="<?php echo $attributes['db_name'];?>">
      <input type="hidden" id="db_s" value="<?php echo $attributes['db_server'];?>">
      <input type="hidden" id="db_l" value="<?php echo $attributes['db_login'];?>">
      <input type="hidden" id="db_p" value="<?php echo $attributes['db_pwd'];?>">
      <input type="hidden" id="db_c" value="<?php echo $attributes['db_charset'];?>">
      <input type="hidden" id="db_i" value="<?php echo $attributes['db_id'];?>">
<!-- Tab01 -->
    <br><br>
    <p class="box" id="chap"></p>
                    
    <div  class="tabs box" id="myTabs">
    </div>

    <div id="tab01">
                
        <table id="db_tab">
                <?php
                $table_str = '';
                
                $ch_str = '';
                
                foreach ($_HOLE -> donorsData as $key => $value) { 
                    if($attributes['db_name'] == $key){
//                        var_dump($value);
                            $table_str .= '<thead>
                        <tr>
                            <th colspan="2">
                            <input type="hidden" id="db_n" value="'.$key.'">
                                Database - "'.$key.'"
                            </th>
                        </tr>
                    </thead> 
                    <tbody>';

                            foreach ($value as $table => $fields) {
                                $style = "";
                                $checked = '';
                                $table_id = array_search($table, $is_tables, TRUE);
                                if($table_id){
                                    $style = "style='background-color: #afffaf'";
                                    $checked = 'checked';

                                }

                                $table_str .= '<tr '.$style.'>
                                    <td>
                                        <input type="checkbox" id="cb_'.$table.'" '.$checked.'>
                                    </td>
                                    <td>

                                    <a href="index.php?act=table&tid='.$table_id.'&db_id='.$attributes['db_id'].'&table='.$table.'" id="'.$table_id.'">
                                        <strong>Table - "'.$table.'"</strong>
                                            </a>
                                        <p>';

                                foreach ($fields as $field) {
                                    $table_str .= '"'.$field.'";&nbsp;';
                                }
                                $table_str .= "</p></td></tr>";
                            }
                        }
               }
                echo "$table_str";
                
                ?>
            </tbody> 
        </table>
     </div> <!-- /tab01 -->

<!--    <div id="tab02">
      
                <fieldset>
                    <p class="nom" style="text-align: center"><input value="Запомнить таблицы" class="input-submit" type="button" id="add_tables"></p> 
                </fieldset>
         
            
          
    </div>  /tab02 -->

</div>
<?php
                echo "$ch_str";
?>