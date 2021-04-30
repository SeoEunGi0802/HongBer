function printName() {
  const name = document.getElementById("name").value;
  document.getElementById("result").innerText = name;
}
$("#file").on('change',function(){
  var fileName = $("#file").val();
  $(".upload-name").val(fileName);
});