<?php
session_start();

define('ROOT_PATH', __DIR__ . '/');
define('ROOT_URL', __DIR__ . '/');

require_once ROOT_PATH . 'Router.php';

Router::addRoute('', 'Home', 'readBlogs');
Router::addRoute('home', 'Home', 'readBlogs');
Router::addRoute('blogLike', 'Like', 'likeOrUnlikePost');
Router::addRoute('login', 'User', 'showLogin');
Router::addRoute('loginSubmit', 'User', 'login');
Router::addRoute('signup', 'User', 'showSignup');
Router::addRoute('signupSubmit', 'User', 'signup');
Router::addRoute('dashboard', 'Dashboard', 'readBlogs');
Router::addRoute('logout', 'User', 'logout');
Router::addRoute('writeBlog', 'Blog', 'showBlogForm');
Router::addRoute('blogSubmit', 'Blog', 'writeOrEditBlog');
Router::addRoute('deleteBlog', 'Blog', 'deleteBlog');
Router::addRoute('editBlog', 'Blog', 'showBlogForm');
Router::addRoute('TagPostsAPI', 'TagPosts', 'getTagPosts');
Router::addRoute('BlogLikesAPI', 'BlogLikes', 'getBlogLikes');

$requestUrl = $_SERVER['REQUEST_URI'];
$basePath = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
$url = str_replace($basePath, '', $requestUrl);

Router::run($url);
