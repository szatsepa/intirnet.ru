<script type="text/javascript">
    $(document).ready(function(){
        
         $("#myTabs").css({'width':'47%','margin':'0 auto'});
         $("#myTabs > p").css({'font-size':'1.4em','font-weight':'bold','text-align':'center'});
         $("#tab01").css('margin', '8px auto');
         $("#tab02").hide().css({'width':'66%','margin':'12px auto'});
         $("#about_bottom").css({'width':'100%'});
         $(".col50").css({'position':'relative','width':'50%','float':'left'});
         $("#right_side").css({'position':'relative','width':'50%','float':'left','padding-top':'66px'} );
         $("#aside").css({'position':'relative','float':'left','width':'12%'});
         
    });
</script>

<div id="content" class="box">   
                    <!-- Tab01 -->
                    
            

    <div  class="tabs box" id="myTabs">
        <p>Базы данных.</p>
<!--        <ul>    
            <li><span><strong></strong></span></li>
        </ul>-->
    </div>

    <div id="tab01">

        <table id="customers_tab">
            <thead>

            </thead> 
            <tbody>
                <tr>
                    <th class="t-center">ID</th>
                    <th class="t-center">Data base</th>
                    <th class="t-center">Login</th>
                    <th class="t-center">Password</th>
                    <th class="t-center">Address</th>
                    <th class='t-center'>Charset</th>
                    <th class='t-center'>Query</th>
                </tr>
<?php

foreach ($res_data as $value) {
     echo "<tr id='r_$value[id]'><td class='t-right'>$value[id]</td><td>$value[db_name]</td><td class='smaller'>$value[login]</td><td class='smaller'>$value[password]</td><td class='smaller t-center'>$value[addr]</td><td class='smaller t-center'>$value[db_query]</td><td class='t-center'><a id='e_$value[id]' class='ico-edit' title='Редактировать'></a><a id='set_$value[id]' class='ico-delete' title='Удалить'></a></td></tr>";
}
?>
            </tbody>
        </table>
    </div> <!-- /tab01 -->

</div>
