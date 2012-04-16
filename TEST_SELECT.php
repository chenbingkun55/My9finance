<head>
<meta http-equiv="Content-Type" ontent="text/html; charset=gb2312" />
<title>表单元素[select下拉列表]制作二级联动菜单</title>
<?php
$link = mysql_connect('localhost','root','root') or die( mysql_error());
  mysql_select_db('cshouse',$link) or die('db error');
  mysql_query("set Names'gbk'");
  /*$sql = "Select * from zgy_classplace where upid=0 order by id asc";
  $result = mysql_query( $sql );
  $i =1;
  $count = mysql_num_rows( $result );
  $b=',';
  while( $rs = mysql_fetch_array( $result  ) )
  {
   if( $i==$count ){ $b =''; }
   echo " new Array("$rs[id]","$rs[cntitle]")$b nt";
   $i++;
  }
  echo ");";
  */
  
  ?>
<script language="javascript">
//下面函数是演示二，联动菜单的处理代码
function makeplace_a(x){
    var form2=document.wane_search.one.options.length;//这句解释同上
    var wane_searchl=new Array(form2)//新建一个数组，项数为第一个下拉列表的项数
    for(i=0;i<form2;i++)//循环第一个下拉列表的项数那么多次
        wane_searchl[i]=new Array();//子循环
        //下面是给每个循环赋值  
    var place_a=document.wane_search.place_a;//方便引用

 <?php 
  $sql = "Select * from zgy_classplace where upid=0 ";
  $result = mysql_query( $sql );
  $j =1;
  while( $rs = mysql_fetch_array( $result ) )
  {
   
   $sql = mysql_query("Select * from zgy_classplace where upid='$rs[id]' and upid<>0") ;
   $i =0;
  
   while( $p =mysql_fetch_array( $sql ) )   {
    
     echo "wane_searchl[$j][$i] = new Option("$p[cntitle]","$p[id]"); nt";
     $i++;
     
    
   }
   $j++;
  }
 ?>
    for(m=place_a.options.length-1;m>0;m--)
    //这个要看清楚,因为要重新填充下拉列表的话必须先清除里面原有的项,清除和增加当然是有区别的了,所以用递减
        place_a.options[m]=null;//将该项设置为空,也就等于清除了
    for(j=0;j<wane_searchl[x].length;j++){//这个循环是填充下拉列表
        place_a.options[j]=new Option(wane_searchl[x][j].text,wane_searchl[x][j].value)
        //注意上面这据,列表的当前项等于 新项(数组对象的x,j项的文本为文本，)
    }
    place_a.options[0].selected=true;//设置被选中的初始值
}
</script>
</head>
<body>
<form id="form20" name="wane_search" method="post" action="">
  <select name="one" size="1" onchange="makeplace_a(options.selectedIndex)">
  <option value="">---请选择省份---</option>
  <?php
    $sql_pr = "Select * from zgy_classplace where upid=0";
  $result_pr = mysql_query( $sql_pr );
  while( $rs_pr = mysql_fetch_array( $result_pr ) )
  {
   echo "<option value=$rs_pr[id]>$rs_pr[cntitle]</option> nt";
  }
  ?>   
  </select>
  <select name="place_a">
  <option value="">---请选择城市---</option>
    
  </select>
  <label>
  <input type="submit" name="Submit" value="提交">
  </label>
</form>
<?php
if($_POST)
{
 print_r($_POST);
}

?>
</body>
</html>
