
console.log('app running!');
var app = angular.module("wpMap", ['ngSanitize', 'ngResource', 'rzModule']);
app.service('wp', function ($resource, $q, $http) {
    var wp = {};
    wp.allPosts = function () {
        var results = [];
        var posts = $resource( url + "/wp-json/wp/v2/sitio?per_page=100").query();
        $q.all([posts.$promise]).then( function (data) {
            var psts = data[0];
            psts.forEach(function(pst) {
                pst.distance = 0;
                results.push(pst);
            });
        });
        var posts2 = $resource( url + "/wp-json/wp/v2/sitio?per_page=100&page=2").query();
        $q.all([posts2.$promise]).then( function (data) {
            if (data[0].length > 0) {
              var psts = data[0];
              psts.forEach(function(pst) {
                  pst.distance = 0;
                  results.push(pst);
              });
            }
        });
        return results
    }
    wp.roteiros = function () {
        var results = [];
        var posts = $resource( url + "/wp-json/wp/v2/roteiro?per_page=100").query();
        $q.all([posts.$promise]).then( function (data) {
            var psts = data[0];
            psts.forEach(function(pst) {
              var cidadeInfo = [];
              var cidadesInfo = []
              pst.cidade.forEach(function(cidade) {
                var getCidade = $resource( url + "/wp-json/wp/v2/cidade/" + cidade).get();
                  $q.all([getCidade.$promise]).then( function (data) {

                    cidadesInfo.push(data[0])
                });
              })
              pst.cidadeInfo = cidadesInfo;
              results.push(pst);
              console.log(pst)
            });
        });
        return results
    }
    wp.getCidades = function () {
        var results = [];
        var posts = $resource( url + "/wp-json/wp/v2/cidade").query();
        $q.all([posts.$promise]).then( function (data) {
            var tags = data[0];
            tags.forEach(function(tag) {
                results.push(tag);
            });
        });
        return results
    }
    wp.getTags = function () {
        var results = [];
        var posts = $resource( url + "/wp-json/wp/v2/tags").query();
        $q.all([posts.$promise]).then( function (data) {
            var tags = data[0];
            tags.forEach(function(tag) {
                results.push(tag);
            });
        });
        return results
    }
    wp.tagPosts = function (tag) {
        var results = [];
        var posts = $resource( url + "/wp-json/wp/v2/sitio?per_page=100&tags=:tags", {tags: tag}).query();
        $q.all([posts.$promise]).then( function (data) {
            var psts = data[0];
            psts.forEach(function(pst) {
                pst.distance = 0;
                results.push(pst);
            });
        });
        return results
    }

    return wp;
});
app.controller('MainMap', ['wp', '$scope', function(wp, $scope) {
  var allposts = wp.allPosts();
  $scope.posts = allposts;

  var map;
  var markers = [];
  var infowindows = [];

    // Initialize map
  function initMap() {
    var latlng = new google.maps.LatLng(-23.9738609,-46.3367274);
    var mapOptions = {
      // scrollwheel: false,
      zoom: 10,
      minZoom: 4,
      center: latlng,
      // styles: styles,
      mapTypeControl: false,
      fullscreenControl: false,
      streetViewControl: false,
      mapTypeId: 'satellite',
      mapZoomControl: true,
    }
    // Create map
    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    // Create info windows and markers to all posts
    setTimeout(function() {
      $scope.posts.forEach(function(post) {

        var contentString = '<div class="infowindow card"><img class="card-img-top" src="' + post.img_thumbnail + '" alt=""><div class="card-body"><h3>' + post.title.rendered + '</h3><a href="' + post.link + '" target="_self"><p>EXPLORAR</p></a>' + '</div></div>';

        // Create Infowindos
        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          id: post.id,
        });

        google.maps.event.addListener(infowindow, 'domready', function() {
           var iwOuter = $('.gm-style-iw');
           var iwBackground = iwOuter.prev();
           iwBackground.children(':nth-child(2)').css({'display' : 'none'});
           iwBackground.children(':nth-child(4)').css({'display' : 'none'});
        });
        infowindows.push(infowindow);

        // Create markers
        var marker = new google.maps.Marker({
          position: {lat: parseFloat(post.lat), lng: parseFloat(post.lng)},
          map: map,
          id: post.id,
          icon: url + '/wp-content/themes/wpmaps/img/pin.png'
        });
        markers.push(marker);

        // Add click listener to markers
        marker.addListener('click', function() {
          infowindows.forEach(function(info) {
            info.close();
          })
          infowindow.open(map, marker);
          setTimeout(function() {
            $('.gm-style-iw').next().addClass('closebtn');
          },400)
          if (map.getZoom() < 16) {map.setZoom(20);}
          map.setCenter(marker.position);
          map.panBy(0, -100);
        });

      });
      var clusterStyle = [{
        url: url + '/wp-content/themes/wpmaps/img/clusterer/m1.png',
        height: 68,
        width: 53,
        anchor: [19, 0],
        textColor: '#ffffff',
        textSize: 12
      }]
      // Add a marker clusterer to manage the markers.
      var markerCluster = new MarkerClusterer(map, markers,
          {maxZoom: 13, imagePath: url + '/wp-content/themes/wpmaps/img/clusterer/m', styles: clusterStyle});
      }, 800)

  } // initMap() end


    $scope.filterTag = function (tag) {

      infowindows.forEach(function(info) {
        info.close();
      })
      var tagposts = [];
      allposts.forEach(function(post, index) {
        if (post.tags.length > 0) {
          post.tags.forEach(function(ptag, index) {
            if (ptag == tag) {
              tagposts.push(post)
            }
          })
        }
      })
      $scope.posts = tagposts;
      // $scope.find_closest_markers();
      markers.forEach(function(marker) {
        // if (! marker.tags.length > 0) {
            marker.setVisible(false);
        // }
        marker.tags.forEach(function (markertag) {
            // If is same category or category not picked
            if (markertag == tag && marker.tags.length > 0) {
                marker.setVisible(true);
            }
        });


      })

      map.setZoom(11);
      map.setCenter({lat: -23.622133, lng:-46.6075299});

    }

    $scope.pop = function (post) {

      infowindows.forEach(function(info) {
        info.close();
      })
      var nfow = infowindows.filter(function( obj ) {
        if (obj.id == post.id) {
            return obj
        }
      });
      var mrkr = markers.filter(function( obj ) {
        return obj.id == post.id;
      });
      console.log(nfow)
      nfow[0].open(map, mrkr[0])
      if (map.getZoom() < 14) {map.setZoom(18);}

      map.setCenter(mrkr[0].position)
      window.scrollTo(0,0);
    }


    $scope.mais = function () {
      $scope.posts = allposts.slice(0);

      markers.forEach(function(marker) {
        marker.setVisible(true);
      });
      infowindows.forEach(function(info) {
        info.close();
      })
      map.setZoom(11);
      map.setCenter({lat: -23.622133, lng:-46.6075299});
    }
    var once = 0
    $scope.initmap = function() {
      setTimeout(function() {
        if (once == 0) {
          initMap();

          once++;
        }

      }, 30)

    }

}]);

app.controller('Roteiro', ['wp', '$scope', function(wp, $scope) {
  var allposts = wp.roteiros();
  $scope.posts = allposts;
  // var cidades = wp.getCidades();
  // $scope.cidades = cidades;
  var cidadeposts = [];
  var cidadepostslimit = [];
  $scope.boxclass = function(i, slug) {
    if (i % 4 == 0) {
      return 'col-lg-4 ' + slug;
    } else {
      return 'col-lg-4 ' + slug;
    }
  }
  $scope.slider = {
      minValue: 0,
      maxValue: 20,
      options: {
          floor: 0,
          ceil: 20,
          step: 1,
          onEnd: function() {
            var postsdeslocamento = [];
            console.log(cidadeposts, cidadepostslimit)
            if (cidadeposts.length == 0) {
              $scope.cidadeFilter == 'todas';
              cidadeposts = allposts;
            }
            cidadeposts.forEach(function(post) {
              if (
                $scope.slider.maxValue == $scope.slider.options.ceil && parseInt(post.deslocamento) >=  $scope.slider.minValue
                ||
                parseInt(post.deslocamento) >=  $scope.slider.minValue && parseInt(post.deslocamento) <=  $scope.slider.maxValue) {
                postsdeslocamento.push(post)
              }
            })
            $scope.posts = postsdeslocamento;
          },
          translate: function(value) {
            return value + 'km'
          },
      }
  };
  $scope.cidadeFilter = ''
  $scope.changecity = function() {
    console.log(cidadeposts)
    if ($scope.cidadeFilter == 'todas') {
      cidadeposts = allposts;
      $scope.posts = cidadeposts;
    } else {
      cidadeposts = [];
      cidadepostslimit = [];
      allposts.forEach(function(post, index) {
        post.cidadeInfo.forEach(function(cidade) {
          if (cidade.slug == $scope.cidadeFilter) {
            cidadeposts.push(post)
              if ($scope.slider.maxValue == $scope.slider.options.ceil && parseInt(post.deslocamento) >=  $scope.slider.minValue
              ||
              parseInt(post.deslocamento) >=  $scope.slider.minValue && parseInt(post.deslocamento) <=  $scope.slider.maxValue) {
                cidadepostslimit.push(post)
              }
          }
        });
      $scope.posts = cidadepostslimit;
      })
    }
  }
  $scope.changecat = function() {
    if ($scope.catFilter.categoria == 'todas') {
      $scope.catFilter = {};
    }
  }

}]);

app.controller('RouteMap', ['wp', '$scope', function(wp, $scope) {
  $scope.route = "Hello Route!";
  var sitioLat =document.getElementById("sitio-lat").textContent;
  var sitioLng =document.getElementById("sitio-lng").textContent;

      // Initialize map
  function initMap() {
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
    var latlng = new google.maps.LatLng(sitioLat, sitioLng);
    var mapOptions = {
      scrollwheel: true,
      zoom: 10,
      minZoom: 4,
      center: latlng,
      // styles: styles,
      mapTypeControl: false,
      fullscreenControl: true,
      streetViewControl: false,
      mapTypeId: 'satellite',
      mapZoomControl: true,
    }
    // Create map
    map = new google.maps.Map(document.getElementById('route-map'), mapOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('right-panel'));

    // var control = document.getElementById('floating-panel');
    // control.style.display = 'block';
    // map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);

    var onChangeHandler = function() {
      calculateAndDisplayRoute(directionsService, directionsDisplay);
    };
    document.getElementById('searchRoute').addEventListener('click', onChangeHandler);
  }

  function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    var start = document.getElementById('start').value;
    var end = document.getElementById('end').value;
    var mode = document.getElementById('mode').value;
    directionsService.route({
      origin: start,
      destination: end,
      travelMode: mode
    }, function(response, status) {
      if (status === 'OK') {
        directionsDisplay.setDirections(response);
        document.getElementById('route-map').classList.remove("d-none");
        document.getElementById('route-container').classList.add("visivel");
      } else {
        window.alert('Não foi possível encontrar a rota. Verifique <b>se o endereço foi digitado corretamente</b>, se é pouco específico, ou se o meio de transporte selecionado é compatível com seu local de partida.');
      }
    });
  }

  $(document).ready(function() {
    setTimeout(function(){
      initMap();
    }, 1000)
  });


}])