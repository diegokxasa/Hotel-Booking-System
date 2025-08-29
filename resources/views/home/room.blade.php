      <div class="our_room">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <div class="titlepage">
                          <h2>Our Room</h2>
                          <p>Lorem Ipsum available, but the majority have suffered </p>
                      </div>
                  </div>
              </div>

              <div class="row">
                  @foreach ($room as $rooms)
                      <div class="col-md-4 col-sm-6">
                          <div id="serv_hover" class="room">
                              <div class="room_img">
                                  <figure>
                                      {{-- style="height:200px; width:320px;" --}}
                                      <img src="{{ asset($rooms->image) }}" alt="{{ $rooms->room_title }}"
                                          class="img-fluid rounded">
                                  </figure>
                              </div>
                              <div class="bed_room">
                                  <h3>{{ $rooms->room_type }}</h3>
                                  <p style="padding:10px" class="room_desc">{{ Str::limit($rooms->description, 100) }}
                                  </p>
                                  <a class="btn btn-primary" href="{{ url('room_details', $rooms->id) }}"> Room
                                      Details</a>
                              </div>
                          </div>
                      </div>
                  @endforeach


              </div>
          </div>
      </div>
