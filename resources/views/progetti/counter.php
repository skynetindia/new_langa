<?php
if(isset($_GET["submit"]) && $_GET["submit"] == "submit")
{
?>

<p id="demo"></p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $_GET['t_date']; ?> 00:00:00").getTime();
//console.log(new Date("<?php echo $_GET['t_date']; ?>"));
// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  <?php
  if(strtotime($_GET['f_date']) <= strtotime(date("Y-m-d")))
  {?>
	  var now = new Date().getTime();
	  //console.log(new Date());
  <?php  }  else   { ?>
  	 var now = new Date("<?php echo $_GET['f_date']; ?>").getTime();
  <?php   }   ?>
  	

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
<?php
}
?>
<form action="#" >
From Date: <input type="date" name="f_date" value="<?php if($_GET['f_date']!="") { echo $_GET['f_date']; } else {echo date("Y-m-d");} ?>" />
<br />
To Date:
<input type="date" name="t_date" value="<?php if($_GET['t_date']!="") { echo $_GET['t_date']; } else {echo date("Y-m-d");} ?>" />
<br />
<input type="submit" value="submit" name="submit" />
</form>