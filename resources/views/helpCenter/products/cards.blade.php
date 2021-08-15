<div class="row">
    @foreach($products as $product)
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card w-100">

                <div style="height: 200px">
                @foreach($product->images as $index => $media)
                    @if($index == 0)
                        <img class="card-img-top h-100" src="{{ $media->getUrl('preview') }}" alt="Card image cap">
                    @endif
                @endforeach
                </div>

                <div class="card-body">
                    <div class="product-details" style="height: 110px; max-height: 150px">
                        <div class="text-wrap">
                            <h6 class="card-title">{{ $product->name }}</h6>
                        </div>
                        @php $price = null @endphp
                        @php $isEmpty = count($product->productPrices) < 1 @endphp
                        @php $isSockOut = true @endphp
                        <div class="row mb-3">
                            <div class="col-6">
                                @if(!$isEmpty)
                                    <select class="form-control product_price">
                                        @foreach($product->productPrices as $productPrice)
                                            @php $isEmpty = false; @endphp
                                            @if($loop->first)
                                                @php $price = $productPrice->price @endphp
                                                @if(in_array($productPrice->id, $productStocks))
                                                @php $isSockOut = false; @endphp
                                                @endif
                                            @endif
                                            <option
                                                {{ $loop->first ? 'selected' : '' }}
                                                value="{{ $productPrice->id }}"
                                                    data-price="{{ $productPrice->price }}"
                                                    data-saleprice="{{ $productPrice->price - (($productPrice->price * $productPrice->discount) / 100) }}"
                                            >{{ $productPrice->quantity .' '. $productPrice->unit }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="col-6 text-right">
                                <span class="font-weight-bolder price">{{ $price }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                    @if($isEmpty)
                        <button class="btn-block btn btn-danger" disabled>{{ trans('global.unit_not_available') }}</button>
                    @else
                        <button
                            {{ $isSockOut ? 'disabled' : '' }}
                            class="btn-block btn btn-danger add-to-cart-button">{{ $isSockOut ? trans('global.out_of_stock') : trans('global.add_to_cart') }}</button>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="col-12">
        @if ($products->lastPage() > 1)
            <div class="text-center">
                <ul class="pagination float-right">
                    @if($products->currentPage() != 1)
                        <li class="nav-item ">
                            <button
                                class="btn btn-sm btn-dark pagination-button"
                                data-page="{{ $products->currentPage()-1 }}"
                                {{ ($products->currentPage() == 1) ? ' disabled' : '' }}
                            >Previous
                            </button>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <li class="nav-item {{ ($products->currentPage() == $i) ? ' active' : '' }}">
                            <button
                                class="btn btn-sm btn-dark ml-1 pagination-button"
                                data-page="{{ $i }}"
                                {{ ($products->currentPage() == $i) ? ' disabled' : '' }}
                            >{{ $i }}</button>
                        </li>
                    @endfor
                    <li class="nav-item {{ ($products->currentPage() == $products->lastPage()) ? ' disabled' : '' }}">
                        <button
                            class="btn btn-sm btn-dark ml-1 pagination-button"
                            data-page="{{ $products->currentPage()+1 }}"
                            {{ ($products->currentPage() == $products->lastPage()) ? ' disabled' : '' }}
                        >Next
                        </button>
                    </li>
                </ul>
            </div>

        @endif
    </div>
</div>
