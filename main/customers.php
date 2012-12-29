<script type="text/javascript">
	   
//     $(document).ready(function(){
//        $("#user_insert").validate();
//        $("#doc_add").validate();
//		
//		<?php // if (isset($attributes["choose"])) {?>
//	
//		$("#myTabs").hide();
//		$("#tab02").hide();
//		$(".ico-edit").hide();
//	
//		<?php // } ?>	  
//     
//        
//        <?php //     
		
		 if (mysql_numrows($qry_users) > 0) { 
            mysql_data_seek($qry_users,0);
         }
		
        while ($row = mysql_fetch_assoc($qry_users)) {?>//
//        $("#edit<?php echo $row["id"];?>").click(function() {
//            $.getScript('index.php?act=user&uid=<?php echo $row["id"]; ?>');
//        });
//        <?php }
//         if (mysql_numrows($qry_users) > 0) { 
//            mysql_data_seek($qry_users,0);
//         }
         ?>//
//        
//        //$('#myTabs').tabs({ selected: 1});
//        
//     });
//    jQuery.validator.messages.required = "";
//    jQuery.validator.messages.email = "";
//    jQuery.validator.messages.digits = "";    
//    jQuery.validator.defaults.errorClass = "err";
//    jQuery.validator.messages.minlength = jQuery.format("");
  
  	
       
</script>

<div class="tabs box" id="myTabs">
    <ul>    
    	<li><a href="#tab01"><span>Список</span></a></li>
    	<li><a href="#tab02"><span>Создать/Редактировать</span></a></li>        
    </ul>
</div>

<!-- Tab01 -->
<div id="tab01">

    <table>
        <thead>
            
        </thead>
        <tbody>
            <tr>
                <th class="t-center">ID</th>
                <th class="t-center">Ф.И.О.</th>
                <th class="t-center">Телефон</th>
                <th class="t-center">Email</th>
                <th class="t-center">Роль</th>
                <th class="t-center">Роль<br />в сделке</th>
                            <th class="t-center">Теги</th>
                <th class="t-center">Дата<br />рег.</th>
                <th>Действ.</th>
            </tr>

        </tbody>
    </table>
</div> <!-- /tab01 -->

<!-- Tab02 -->
<!--<div id="tab02">-->
     <?php  
        // Для Секретаря вн.коммуникаций доступно назначение контакта
        if ($user["role"] == 14) { ?>
<!--     <div class="box-01" style="display:none;" id="user_append_box">
        <p class="nom">
        <form action="index.php?act=user_append" method="post" id="user_append" name="user_append">
            <input type="hidden" name="contact_append" value="" id="contact_append">
        <label for="media">Агент:</label>
    <select name="agent_append" class="input-text" id="agent_append">
        <?php option ('users',"id","surname,name",0," AND role=4 ");?>
    </select>
	    <input value="Назначить этот контакт" class="" type="submit" id="user_append_submit">
        </form>
        </p>
	 </div>-->
     <?php } ?>
     
<!--    <form action="index.php?act=user_insert" method="post" id="user_insert" name="user_insert">  
        <fieldset>
    	<legend>Основные данные</legend>     
        <div class="col50">
             <p><label for="surname">Фамилия:</label><br />
			    <input size="50" name="surname" value="" class="input-text required" id="surname" type="text"></p>
            <p><label for="name">Имя:</label><br />
			    <input size="50" name="name" value="" class="input-text required" id="name" type="text"></p>
             <p><label for="phone">Телефон:</label><br />
			    <input size="30" name="phone" value="" class="input-text required" id="phone" type="text"></p>
            <p><label for="fax">Факс:</label><br />
			    <input size="30" name="fax" value="" class="input-text" id="fax" type="text"></p>
        </div>
        
        <div class="col50 f-right">
            <p><label for="patronymic">Отчество:</label><br />
			    <input size="50" name="patronymic" value="" class="input-text" id="patronymic" type="text"></p>
            <p><label for="role">Роль:</label><br />
					<select name="role" class="input-text required" id="role">
						<?php  
                            // Для Агента и Секретаря вн.коммуникаций доступны только клиенты
//                            if ($user["role"] == 4 or $user["role"] == 14) {
//                                option ("roles","id","name",12," AND id = 12 ");
//                            } else {
//                                option ("roles","id","name",0,"");
//                            }
                            
                        ?>
					</select></p>
            <p><label for="phone2">Дополнительный телефон:</label><br />
			    <input size="30" name="phone2" value="" class="input-text" id="phone2" type="text"></p>
            <p><label for="email">Электронная почта:</label><br />
			    <input size="30" name="email" value="" class="input-text email" id="email" type="text"></p><br />
        </div>
         <p><label for="postcode">Почтовый индекс:</label><br />
			    <input size="12" name="postcode" value="" class="input-text digits" id="postcode" minlength="6" maxlength="6" type="text"></p>
         <p><label for="address">Почтовый адрес:</label><br />
			    <input size="100" name="address" value="" class="input-text" id="address" type="text"></p>
         <p><label for="comments">Комментарии:</label><br />
			    <textarea cols="95" rows="3" class="input-text" id="comments" name="comments"></textarea></p>
         <p><label for="tags">Теги:</label><br />
			    <input size="100" name="tags" value="" class="input-text" id="tags" type="text"><br />
            <span class="smaller low">несколько тегов разделяются запятыми</span></p>
          
    
        </fieldset>
        <?php  
//        // Для Агента и Секретаря вн.коммуникаций доступны потребности клиента
//        if ($user["role"] == 4 or $user["role"] == 14) {
//            include("dsp/dsp_client_need.php");
//        }
        ?>
        <div class="box-01">
		    <p class="nom"><input value="Создать пользователя" class="input-submit" type="submit" id="user_insert_submit"></p>
		</div> 
    </form>-->
        
<!--        <fieldset id="fieldset_doc" style="display:none;">
    	<legend>Документы</legend>
         
        <div id="user_doc"></div>
        
             Button: Загрузка документов 
             Должна появляться в режиме редактирования 
			<p class="box"><a href="javascript:toggle('upload_1');" class="btn-create"><span>Загрузить</span></a></p>                             
             Upload 
			<div id="upload_1" class="box-01" style="display: none;">

				<form action="index.php?act=doc_add" method="post" enctype="multipart/form-data" id="doc_add" name="doc_add">  
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000000">
                    <input type="hidden" name="query_str" value="<? echo $_SERVER["QUERY_STRING"]; ?>" />
                    <input type="hidden" name="ph" value="/user/" id="ph">
                    <input type="hidden" name="pt" value="user"   id="pt">
                    <input type="hidden" name="pc" value="id"     id="pc">
                    <input type="hidden" name="pv" value=""       id="pv">
					<input type="hidden" name="doc_type" value="1" id="doc_type">
                    
                    <p class="nomt">
						<label for="inputname" class="low">Выберите название из списка:</label><br />
						<select name="inputname" class="input-text required" id="inputname" size="7">
                            <?php // option_doc($udoc);?>
                        </select>
					</p>
 
					
                    <p class="nom"><input size="62" name="userfile" class="input-text-02 required" type="file"></p>
					<br />
					<p class="nom">
						<input value="Загрузить" class="input-submit" type="submit">						
					</p>
					
				</form>

			</div>  /upload 
        
        </fieldset>-->
        
    
<!--</div>  /tab02 -->

