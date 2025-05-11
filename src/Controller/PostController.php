<?php

namespace App\Controller;

use NamCao\Framework\Controller\AbstractController;
use NamCao\Framework\Http\Response;

class PostController extends AbstractController {
    public function show(int $id): Response {
        return $this->render('post.html.twig', ['postId' => "<script>alert('namdepzai)</script>"]);
    }

     public function create(): Response {
        return $this->render('create-post.html.twig');
    }
}