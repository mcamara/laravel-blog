app.factory('PostsServices', function($http, $sanitize, $q){
	return {
		fetchPosts: function(page){
			var ret = null;
			$.ajax({
			  type: "GET",
			  url: "?page="+page,
			  dataType: "json",
			  async: false, 
			  success: function(result) {
			  	ret = result;
			  }
			});
			return ret;
		}
	}
});

function postCtrl($scope,PostsServices)
{
	$scope.posts = null;
	$scope.current_page = 1;
	$scope.last_page = 1;
	$scope.total_posts = 0;
	$scope.per_page = 0;
	$scope.changePage = function(page){
		var data = PostsServices.fetchPosts(page);
		$scope.posts = data.data;
		$scope.current_page = page;
		$scope.last_page = data.last_page;
		$scope.total_posts = data.total;
		$scope.per_page = data.per_page;
	}
	$scope.previousPage = function(){
		if($scope.current_page == 1) return;
		$scope.changePage($scope.current_page-1);
	}
	$scope.nextPage = function(){
		if($scope.current_page == $scope.last_page) return;
		$scope.changePage($scope.current_page+1);
	}
}