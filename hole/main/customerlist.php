<?php
if(isset($attributes['adderror'])){
    ?>
<script type="text/javascript">
    alert("Пользователь с таким е-мейлом уже зарегистрирован!");
</script>
<?php
}
?>
<div id="content" class="box">   
  <input type="hidden" id="uid" value="">
  <input type="hidden" id="сid" value="">
  <input type="hidden" id="str_addr" value="act=customers">
  
    <?php
    if(isset($attributes['role'])){
                echo "<input type='hidden' id='s_role' value='{$attributes['role']}'>";
          }
    if(isset($attributes['buk'])){
                echo "<input type='hidden' id='s_buk' value='{$attributes['buk']}'>";
          }      
    ?>
                    <!-- Tab01 -->
        <p class="box" id="chap"><strong><?php echo $roles[$str_role];?>.</strong></p>
        <p class="box" id="p-filter"><a id="a_role" class="btn-info"><span>Роли</span></a><a id="a_alphabet" class="btn-info"><span>Алфавит</span></a><a id="a_all" class="btn-info"><span>Все</span></a></p>            
    
<!-- Upload -->
<fieldset id="fieldset_filter_roles" style="display:none;">
	<legend>Теги</legend>
    <?php include ("../main/roles.php");?>
</fieldset>

<!-- Upload --> 
<fieldset id="fieldset_filter_alphabet" style="display:none;">
	<legend>Алфавит</legend>
    <?php  include ("../main/alphabet.php");?>
</fieldset>        
<!-- href="index.php?act=srch"-->
    <div  class="tabs box" id="myTabs">
        <ul> 
    	<li><a id="t01"><span>Список</span></a></li>
    	<li><a id="t02"><span>Создать</span></a></li> 
        <li><a id="t03"><span>Поиск</span></a></li>
        <li><a id="t04"><span><img src="../design/circle.gif" width="27" height="27"></span></a></li>
    </ul>
    </div>
<!-- class="ui-tabs-panel"-->
    <div id="tab01">

        <table id="customers_tab" >
            <thead>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Ф.И.О.</th>
                    <th class="t-center">Телефон</th>
                    <th class="t-center">Email</th>
                    <th class='t-center'>Действ.</th>
                </tr>
            </thead> 
            <tbody>
                
    <?php
    foreach ($customers as $value) {
        ?>
        <tr id='r_<?php echo $value[id];?>'>
            <td class='t-right'><?php echo $value['id'];?></td>
            <td><?php echo "$value[surname]&nbsp;{$value['name']}&nbsp;{$value['patronymic']}";?></td>
            <!--<td class='smaller'><?php echo $value['role'];?></td>-->
            <td class='smaller'><?php echo $value['phone'];?></td>
            <td class='smaller'><a href='mailto:<?php echo $value['email'];?>'><?php echo $value['email'];?></a></td>
            <!--<td class='smaller'><?php echo $value['db_data_id'];?></td>-->
            <td class='t-center'>
                <a id='e_<?php echo $value['id'];?>' class='ico-info' title='Смотреть'></a>
                <a id='d_<?php echo $value['id'];?>' class='ico-delete' title='Удалить'></a>
            </td>
        </tr>

      <?php          }
                ?>
            </tbody>
        </table>
    </div> <!-- /tab01 -->
    <div id="tab03">
        <table id="customer_data" >
            <thead>
                
            </thead>
            <tbody>
                
            </tbody>            
        </table>
    </div>
<!-- TAB02 -->
<div id="tab02">
    <form id="customers_data">
        <fieldset>
    	<legend>Основные данные</legend>     
        <div class="col50" id="cu_h">
             <p><label for="surname">Фамилия:</label><br />
			    <input value="" class="input-text required" id="surname" type="text"></p>
             <p><label for="name">Имя:</label><br />
			    <input value="" class="input-text required" id="name" type="text"></p>
            <p><label for="patronymic">Отчество:</label><br />
			    <input value="" class="input-text" id="patronymic" type="text"></p>
            
             
<!--            <p><label for="fax">Факс:</label><br />
			    <input size="30" value="" class="input-text" id="fax" type="text"></p>-->
        </div>
        
        <div class="col50 f-right" id="cu_f">
            <p><label for="phone">Телефон:</label><br />
			    <input value="" class="input-text required" id="phone" type="text"></p>
            
<!--            <p><label for="role">Роль:</label><br />
                            <input value="Заказчик" class="input-text" id="role" readonly type="text"></p>-->
            <p><label for="email">Электронная почта:</label><br />
			    <input value="" class="input-text email" id="email" type="text"></p><br />
        </div>
        </fieldset>
    </form> 
                <div class="box-01" id="sbmt_btn">
		    <p class="nom"><input value="Сохранить" class="input-submit" type="button" id="user_insert_submit"></p>
		</div> 
   
        
        <fieldset id="fieldset_doc" style="display:none;">        
    
</div> <!-- /tab02 -->
</div><!-- Content -->