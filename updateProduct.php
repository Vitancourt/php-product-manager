
<!doctype html>
<html ⚡>
<head>
  <title>Webjump | Backend Test | Update Product</title>
  <meta charset="utf-8">

<link  rel="stylesheet" type="text/css"  media="all" href="css/style.css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet">
<meta name="viewport" content="width=device-width,minimum-scale=1">
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script></head>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/axios/dist/axios.min.js"></script>
  <!-- Header -->
<amp-sidebar id="sidebar" class="sample-sidebar" layout="nodisplay" side="left">
  <div class="close-menu">
    <a on="tap:sidebar.toggle">
      <img src="images/bt-close.png" alt="Close Menu" width="24" height="24" />
    </a>
  </div>
  <a href="index.php"><img src="images/menu-go-jumpers.png" alt="Welcome" width="200" height="43" /></a>
  <div>
    <ul>
      <li><a href="categories.php" class="link-menu">Categorias</a></li>
      <li><a href="products.php" class="link-menu">Produtos</a></li>
    </ul>
  </div>
</amp-sidebar>
<header>
  <div class="go-menu">
    <a on="tap:sidebar.toggle">☰</a>
    <a href="index.php" class="link-logo"><img src="images/go-logo.png" alt="Welcome" width="69" height="430" /></a>
  </div>
  <div class="right-box">
    <span class="go-title">Administration Panel</span>
  </div>    
</header>  
<!-- Header -->
  <!-- Main Content -->
  <main class="content">
    <h1 class="title new-item">Edit Product</h1>
    <span id="main-loading"></span>
    <form id="form" method="post" action="public/index.php/product/update" style="display:none;">
      <input type="hidden" name="product[id]" id="id" required>
      <div class="input-field">
        <label for="sku" class="label">Product SKU</label>
        <input type="text" id="sku" class="input-text" name="product[sku]" required /> 
      </div>
      <div class="input-field">
        <label for="name" class="label">Product Name</label>
        <input type="text" id="name" class="input-text" name="product[name]" required/> 
      </div>
      <div class="input-field">
        <label for="price" class="label">Price</label>
        <input type="text" id="price" class="input-text" name="product[price]" required/> 
      </div>
      <div class="input-field">
        <label for="quantity" class="label">Quantity</label>
        <input type="text" id="quantity" class="input-text" name="product[quantity]" required /> 
      </div>
      <div class="input-field">
        <label for="category" class="label">Categories</label>
        <span id=loading></span>
        <select multiple id="category" class="input-text" name="product[categories][]" required>
        </select>
      </div>
      <div class="input-field">
        <label for="description" class="label">Description</label>
        <textarea id="description" class="input-text" name="product[description]" required></textarea>
      </div>
      <div class="actions-form">
        <a href="products.php" class="action back">Back</a>
        <input class="btn-submit btn-action" type="submit" value="Save Product" />
      </div>
      
    </form>
  </main>
  <!-- Main Content -->

  <!-- Footer -->
<footer>
	<div class="footer-image">
	  <img src="images/go-jumpers.png" width="119" height="26" alt="Go Jumpers" />
	</div>
	<div class="email-content">
	  <span>go@jumpers.com.br</span>
	</div>
</footer>
 <!-- Footer -->
</body>
<script>
  axios.get('public/index.php/category', {})
  .then(function (response) {
    $("#loading").html('Carregando...');
    console.log(response.data);
    var full = "";
    response.data.forEach(function(obj){
      full = full + "<option value='"+obj.id+"'>"+obj.name+"</option>";
    });
    $("#category").html(full);
    $("#loading").html("");
  })
  .catch(function (error) {
    console.log(error);
  });
  var params = window.location.search.substring(1).split('?');
  params = params[0].split("=");
  axios.get('public/index.php/product/single/'+params[1], {})
  .then(function (response) {
    $("#main-loading").html('Carregando...');
    console.log(response.data);
    $("#id").val(response.data.id);
    $("#sku").val(response.data.sku);
    $("#name").val(response.data.name);
    $("#price").val(response.data.price);
    $("#quantity").val(response.data.quantity);
    if (response.data.categories) {
        response.data.categories.forEach(function(obj){
            el = document.getElementById("category");
            for (var i = 0; i < el.length; i++) {
                if (el[i].value == obj.id) {
                    el[i].selected = true;
                }
            }
        });
    }
    $("#description").val(response.data.description);
    $("#main-loading").html("");
    $("#form").show();
  })
  .catch(function (error) {
    console.log(error);
  });
</script>
</html>
