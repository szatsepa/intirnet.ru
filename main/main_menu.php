<?php
include 'action/check_differences.php';

$qstring = $_SERVER[QUERY_STRING];

$qstring = "index.php?".str_replace('&chng=1', "", $qstring)."&chng=1";

if(count($differences)!=0){
?>
<script type="text/javascript">
    if(confirm("В базах донорах имеются измененые данные!\n\t\tИзменить данные?")){
        document.location = "<?php echo $qstring;?>";
    }
</script>
<?php
}
if($add_rows > 0){
//    unset($differences);
?>
<script type="text/javascript">
    alert("Изменено <?php echo $add_rows;?> строк");
</script>
<?php
}
?>
<script type="text/javascript">
    $(document).ready(function(){
//        $("#aside").css({'width':'12%'});
//         $("#content ").css({'width':'88%'});
//         $("#aside ul li a").css({'width':'66%'});
    });
</script>
<!-- Columns -->
	<div id="cols" class="box"><!-- Aside (Left Column) -->
		<div id="aside" class="box">
<!--
			<div class="padding box">

				 Logo (Max. width = 200px) 
				<p id="logo"><a href="#"><img src="../tmp/logo.gif" alt="Our logo" title="Visit Site" /></a></p>
				
			</div>  /padding -->
                        <ul class="box">				
                
				<li ><a href="index.php?act=main">Клиенты ресурсов</a>
<!--                                <ul id="users">
                                    <li><a href="index.php?act=roles">Роли участников системы</a></li>
                                    <li><a href="index.php?act=utd&amp;utn=pd_roles">Роли продавцов</a></li>
                                    <li><a href="index.php?act=utd&amp;utn=pk_roles">Роли покупателей</a></li>
                                    <li><a href="index.php?act=utd&amp;utn=buh_roles">Роли бухгалтерии</a></li>
                                    <li><a href="index.php?act=o_type_permit">Карточки для Агентов</a></li>
                                </ul>-->
                                </li>
                
				<li ><a href="index.php?act=res">Ресурсы и базы</a>
<!--                    <ul id="products">
                         <li><a href="index.php?act=utd&amp;utn=o_type">Типы карточек</a></li>     
						 <li><a href="index.php?act=o_div">Разделы карточек</a></li>  
						 <li><a href="index.php?act=o_inp&o_div=0">Общие характеристики</a></li>  						 
                    </ul>-->
                                </li>   
				
				<li ><a href="index.php?act=adm">Администрация</a>
<!--                    <ul id="docs">
                         <li><a href="index.php?act=utd&amp;utn=doc_types">Типы</a></li>     
						 <li><a href="index.php?act=discuss_permit">Обсуждение</a></li>
                    </ul>-->
                </li>   
				
                
                <li><a href="index.php?act=srch">Поиск</a>
<!--                    <ul id="reklama">
                        <li><a href="index.php?act=utd&amp;utn=media">Рекламные носители</a></li>                                -->
                    </ul>
                </li>                				
				
<!--				<li id="messages">
					<a href="index.php?act=messages">Сообщения</a>
				</li>-->
<!--				
				<li><a href="#">Подсчет баллов</a>
                    <ul id="ball">
                        <li>
							<a href="index.php?act=utd&amp;utn=b_process">Процессы</a>
						</li>
						<li>
							<a href="index.php?act=balls">Баллы</a>
						</li>                        
                    </ul>
                </li>-->
				
<!--				<li id="containers">
					<a href="index.php?act=containers">Контейнеры</a>
				</li>-->
				      
			</ul>
            		</div> <!-- /aside -->

		<hr class="noscreen" />

		<!-- Content (Right Column) -->
<!--		<div id="content" class="box">    </div>  /content -->        
<!--            <br />-->

		

	
