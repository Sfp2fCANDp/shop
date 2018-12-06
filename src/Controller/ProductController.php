<?php

    namespace App\Controller;

    use App\Entity\Category;
    use App\Entity\Product;
    use App\Form\ProductType;
    use App\Repository\ProductRepository;
    use App\Repository\CategoryRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

    /**
     * @Route("/product")
     */
    class ProductController extends AbstractController
    {
        /**
         * @Route("/", name="product_index", methods="GET")
         */
        public function index(ProductRepository $productRepository): Response
        {
            return $this->render('product/index.html.twig', ['products' => $productRepository->findAll()]);
        }


        /**
         * @Route("/new", name="product_new", methods="GET|POST")
         */
        public function new(Request $request): Response
        {
            //dd($this->findAll());
            $product = new Product();

            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                return $this->redirectToRoute('product_index');
            }

            return $this->render('product/new.html.twig', [
                'product' => $product,
                'form' => $form->createView(),
            ]);
        }

        /**
         * @Route("/{id}", name="product_show", methods="GET")
         * @Entity("product", expr="repository.find(id)")
         */
        public function showAction(Product $product): Response
        {
            return $this->render('product/show.html.twig', ['product' => $product]);
        }

        /**
         * @Route("/{id}/edit", name="product_edit", methods="GET|POST")
         */
        public function edit(Request $request, Product $product): Response
        {
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
            }

            return $this->render('product/edit.html.twig', [
                'product' => $product,
                'form' => $form->createView(),
            ]);
        }

        /**
         * @Route("/{id}", name="product_delete", methods="DELETE")
         */
        public function delete(Request $request, Product $product): Response
        {
            if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($product);
                $em->flush();
            }

            return $this->redirectToRoute('product_index');
        }

        /**
         * @Route("/search", name="ajax_search", methods="GET")
         */
        public function searchAction(Request $request)
        {
            var_dump('text');
            $em = $this->getDoctrine()->getManager();

            $requestString = $request->get('q');

            $products = $em->getRepository('App:Product')->findProductsByString($requestString);


            if (!$products) {
                $result['products']['error'] = "No records found";
            } else {
                $result['products'] = $this->getRealProducts($products);
            }

            return new Response(json_encode($result));
        }

        public function getRealProducts($products){

            foreach ($products as $product){
                $realProducts[$product->getId()] = $product->getName();
            }

            return $realProducts;
        }
    }
