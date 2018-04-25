<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}

    <title>Products Inventory</title>
    <link href="css/app.css" type="text/css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/tether.min.js" type="text/javascript"></script>
</head>

<body>
<div class="container-fluid">

    <div class="row">
        <div class="container-fluid">
            <div class="col-md-6 col-md-offset-3">
                <div style="text-align:center">
                    <h2>Product Inventory</h2>
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="container-fluid">
            <div class="col-md-4 col-md-offset-4">
                <h4>Add New Product</h4>

                <div class="row">
                    <div class="container-fluid">
                            <div class="form-group">
                                <div class="container-fluid">
                                    <label for="product_name">
                                        Name
                                    </label>
                                    <input id="product_name" class="form-control" name="product_name" type="text" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="container-fluid">
                                    <label for="product_price">
                                        Price per Item
                                    </label>
                                    <input id="product_price" class="form-control" name="product_price" type="number" value="0.00" min="0"required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="container-fluid">
                                    <label for="product_quantity">
                                        Quantity
                                    </label>
                                    <input id="product_quantity" class="form-control" name="product_quantity" type="number" value="0" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="container-fluid">
                                    <button class="btn btn-success" id="submit-btn">Submit</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="container-fluid">
            <div class="col-md-8 col-md-offset-2">
                <h4>Product Inventory</h4>

                <script type="text/javascript">
                    $(document).ready(function () {
                            var productsContainer = $('.products-container');

                            var prepareTemplateProduct = function (product) {
                                var templateProduct = "<tr>";
                                templateProduct += "<td>"
                                templateProduct += product.prodID
                                templateProduct += "</td>"
                                templateProduct += "<td>"
                                templateProduct += product.prodName
                                templateProduct += "</td>"
                                templateProduct += "<td>"
                                templateProduct += product.prodQuantity
                                templateProduct += "</td>"
                                templateProduct += "<td>"
                                templateProduct += product.prodPricePerItem
                                templateProduct += "</td>"
                                templateProduct += "<td>"
                                templateProduct += (product.prodPricePerItem*product.prodQuantity)
                                templateProduct += "</td>"
                                templateProduct += "<td>"
                                templateProduct += product.dateSubmitted
                                templateProduct += "</td>"
                                templateProduct += "</tr>"

                                return templateProduct;
                            };

                        $.ajaxSetup({
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                                type : 'GET',
                                url : '/api/products',

                                success : function(response){
                                    var products = response.data;

                                    for(var i=0; i<products.length; i++)
                                    {
                                        productsContainer.append(prepareTemplateProduct(products[i]));
                                    }
                                },
                                error : function(response){
                                    console.log(response);
                                }
                            });

                        $('#submit-btn').click(function() {
                            $.ajax({
                                type : 'POST',
                                url : '/api/products',
                                data : {
                                    'product_name' : $('#product_name').val(),
                                    'product_quantity' : $('#product_quantity').val(),
                                    'product_price': $('#product_price').val()
                                },
                                success : function(response){
                                    var product = response.data;
                                    productsContainer.append(prepareTemplateProduct(product));

                                    $('#product_name').val('');
                                    $('#product_quantity').val('');
                                    $('#product_price').val('');
                                },
                                error : function(err){
                                    $('body').append("<span class='alert alert-danger'> Error in your input </span>");

                                    $('.alert').delay(5000).hide();
                                }
                            });
                        });
                    });

                </script>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Product Name
                            </th>
                            <th>
                                Quantity in Stock
                            </th>
                            <th>
                                Price/Item
                            </th>
                            <th>
                                Total Value Number
                            </th>
                            <th>
                                Date Submitted
                            </th>
                        </tr>
                        </thead>

                        <tbody class="products-container">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer-wrapper">
    <div class="container-fluid" style="text-align:center">
        <h5>designed by Samuel Yute (theInscriber!)</h5>
    </div>
</div>
</body>

</html>
