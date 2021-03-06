@extends('frontend.include.app')

@section('content')
    <div class="page-content page-details">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Product Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="store-gallery" id="item">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="col-lg-8" data-aos="zoom-in">
                            <transition name="slide-fade" mode="out-in">
                                <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="main-image"
                                    width="730px" height="467px" alt="" />
                            </transition>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="row">
                            <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos" :key="photo.id"
                                data-aos="zoom-in" data-aos-delay="100">
                                <a href="#" @click="changeActive(index)">
                                    <img :src="photo.url" class="w-100 thumbnail-image"
                                        :class="{ active: index == activePhoto }" alt="" width="160px" height="103px" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="store-details-container" data-aos="fade-up">
            <section class="store-heading">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1>{{ $data->ProductName }}</h1>
                            <div class="owner">{{ $data->Categories }}</div>
                            <div class="price"> Rp {{ number_format($data->Price) }}</div>
                        </div>
                        <div class="col-lg-2" data-aos="zoom-in">
                            @auth
                                <form action="{{ route('detail-add', $data->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <button type="submit" class="btn btn-success px-4 text-white btn-block mb-3">
                                        Add to Cart
                                    </button>
                                </form>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-success px-4 text-white btn-block mb-3">
                                    Sign in to Add
                                </a>
                            @endguest

                        </div>
                    </div>
                </div>
            </section>
            <section class="store-description">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <p>
                                {{ $data->Description }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            @php
            $count = App\Models\Review::where('Products_id',$data -> id)->count();    
        @endphp

            <section class="store-review">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 mt-3 mb-3">
                            <h5>Customer Review ( {{$count}} )
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <ul class="list-unstyled">
                                @foreach ($review as $item)
                                <li class="media" style="height: 100px">
                                    <img src="/images/icon-testimonial-1.png" class="mr-3 rounded-circle" alt="" />
                                    <div class="media-body">
                                        <div class="row">
                                          <h5 class="font-weight-bold">{{ $item -> user -> name}}</h5> 
                                          <div class="startreview ml-5">
                                            @if ($item -> rating == 1)
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star "></span>
                                            <span class="fa fa-star "></span>
                                            <span class="fa fa-star "></span>
                                            <span class="fa fa-star"></span>
    
                                            @elseif($item -> rating == 2 )
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star "></span>
                                            <span class="fa fa-star "></span>
                                            <span class="fa fa-star"></span>
                                                
                                            @elseif($item -> rating == 3)
    
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star "></span>
                                            <span class="fa fa-star"></span>
    
                                            @elseif($item -> rating == 4)
    
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            @elseif($item -> rating == 5)
    
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            @endif
                                          </div>
                      
                                        
                                    </div>
                                        {{ $item -> review}}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                     
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <h5> Beri Ulasan Kepada Product Ini : </h5>
                            <form action="{{ route('addreview',$data -> id)}}" method="POST" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                @method('POST')
                                <div class="stars">
                                    <input class="star star-5" id="star-5" type="radio" name="rating" value="5" />
                                     <label class="star star-5" for="star-5"></label> <input class="star star-4" id="star-4" type="radio" name="rating" value="4"/>
                                      <label class="star star-4" for="star-4"></label> <input class="star star-3" id="star-3" type="radio" name="rating" value="3" /> 
                                      <label class="star star-3" for="star-3"></label> <input class="star star-2" id="star-2" type="radio" name="rating"  value="2"/>
                                       <label class="star star-2" for="star-2"></label> <input class="star star-1" id="star-1" type="radio" name="rating" value="1" />
                                        <label class="star star-1" for="star-1"></label> 
                                </div>
                            <textarea name="review" class="form-control" id="" cols="5" rows="4"> </textarea>
                        
                            <div class="col-lg-10 ">

                            </div>
                            <div class="col-lg-2 mt-4 mr-5">
                                <button class="btn btn-primary"> Add Review  </button>

                                </form>
                            </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="{{ asset('frontend/vendor/vue/vue.js') }}"></script>
    <script>
        var item = new Vue({
            el: "#item",
            mounted() {
                AOS.init();
            },
            data: {
                activePhoto: 0,
                photos: [
                    @foreach ($data->galleries as $gallery)
                        {
                        id: {{ $gallery->id }},
                        url: "{{ Storage::url($gallery->Photos) }}",
                        },
                    @endforeach
                ],
            },
            methods: {
                changeActive(id) {
                    this.activePhoto = id;
                },
            },
        });

    </script>

@endpush

@section('style')
    
<style></style>
<style>
    .stars {
       width: 270px;
       display: inline-block
    }

    .mt-200 {
       margin-top: 200px
    }

    input.star {
       display: none
    }

    .checked {
    color: orange;
    }

    label.star {
       float: right;
       padding: 10px;
       font-size: 36px;
       color: #4A148C;
       transition: all .2s
    }

    input.star:checked~label.star:before {
       content: '\f005';
       color: #FD4;
       transition: all .25s
    }

    input.star-5:checked~label.star:before {
       color: #FE7;
       text-shadow: 0 0 20px #952
    }

    input.star-1:checked~label.star:before {
       color: #F62
    }

    label.star:hover {
       transform: rotate(-15deg) scale(1.3)
    }

    label.star:before {
       content: '\f006';
       font-family: FontAwesome
    }
 </style>
@endsection

