@extends('helpCenter.layout.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input class="form-control" type="text" id="term" placeholder="{{ trans('global.search_product') }}...">
                    </div>
                </div>
            </div>
            <div id="data"></div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const addToCart = productPriceId => {

                $.post("{{ route('helpCenter.add.to.cart') }}", {productPriceId}, result => {
                    if(result.status){

                    }
                    alert(result.message);
                }, 'json');
            }


            $(document).on('change', '.product_price', function () {
                let price = $('option:selected', this).data('price');
                let id = $(this).val();
                $(this).closest('.row').find('.price').text(price);
                let button = $(this).closest('.card-body').find('.add-to-cart-button');
                $(button).prop('disabled', true);
                $.get("{{ route('helpCenter.check.stock.status') }}", {id}, result => {
                    if(result.status){
                        $(button).prop('disabled', false);
                        $(button).text(result.response);
                    }else {
                        $(button).prop('disabled', true);
                        $(button).text(result.response);
                    }
                }, 'json')
            });

            $(document).on('click', '.add-to-cart-button', function () {
                let productPriceId = $(this).closest('.card-body').find('.product_price').val();
                if(productPriceId.length > 0){
                    addToCart(productPriceId)
                }
            });

            const renderProducts = (page = 1) => {
                let term = $('#term').val();
                $.get(`{{ route('helpCenter.products.index') }}?page=${page}`, {term}, result => {
                    $('#data').html(result);
                });
            }
            renderProducts();
            $(document).on('blur', '#term', () => renderProducts());

            $(document).on('click', '.pagination-button', function (){
                let page = $(this).data('page');
                renderProducts(page)
            })

        });

    </script>
@endsection
