let app = angular.module('shopApp', []);
app.controller('shopController', function($scope, $http) {
   $http.get('../products.json').then(function(response) {
      $scope.products = response.data;
      $scope.categories = [...new Set($scope.products.map(product => product.category))];
   });

   $scope.customFilter = function(product) {
      let categoryMatch = $scope.selectedCategory ? product.category === $scope.selectedCategory : true;
      let nameMatch = $scope.searchName ? product.name.toLowerCase().includes($scope.searchName.toLowerCase()) : true;
      return categoryMatch && nameMatch;
   };

   $scope.addToCart = function(title, description, price, discount) {
      let cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];
      let productIndex = cart.findIndex(product => product.title === title && product.description === description && product.price === price);

      if (productIndex !== -1) {
         cart[productIndex].quantity += 1;
      } else {
         let product = { title, description, price, discount, quantity: 1 };
         cart.push(product);
      }

      localStorage.setItem('cart', JSON.stringify(cart));
      swal({
         title: "Agregado al Carrito!",
         text: "El producto ha sido agregado al carrito de compras.",
         icon: "success",
         button: "OK",
      }).then(function() {

         location.reload();
        });
   };
});
