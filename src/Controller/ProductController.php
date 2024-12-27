<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    private const PRINTFUL_API_URL = 'https://api.printful.com/products';
    private $accessToken;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
       // $this->accessToken = $params->get('PRINTFUL_ACCESS_TOKEN');
        $this->accessToken = 'ydQ41i2kPt5uFboA0imJw2iY9jXjlbv0nsn7dSk9';    
    }

    /**
     * Fonction pour appeler l'API Printful
     */
    private function fetchPrintfulData(): ?array
    {
        $ch = curl_init(self::PRINTFUL_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->accessToken, 
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpStatusCode === 200) {
            return json_decode($response, true)['result'] ?? null;
        }

        return null;
    }

    /**
     * Synchronise les données de l'API Printful avec la base de données
     */
    private function synchronizeProducts(array $apiProducts): void
    {
        foreach ($apiProducts as $productData) {
            $existingProduct = $this->entityManager
                ->getRepository(Product::class)
                ->findOneBy(['idPrintfull' => $productData['id']]);

            $productEntity = $existingProduct ?: new Product();
            $productEntity->setIdPrintfull($productData['id']); // Clé obligatoire

            // Mapper dynamiquement les autres données
            $this->mapDataToEntity($productData, $productEntity);

            if (!$existingProduct) {
                $this->entityManager->persist($productEntity);
            }
        }

        $this->entityManager->flush();
    }

    /**
     * Mappe dynamiquement les données de l'API sur l'entité
     */
    private function mapDataToEntity(array $data, Product $product): void
    {
        foreach ($data as $key => $value) {
            // Convertir les dimensions si elles sont au format tableau
            if ($key === 'dimensions' && is_array($value)) {
                $value = json_encode($value); // Convertir en JSON ou autre format lisible
            }

            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (method_exists($product, $setter)) {
                $product->$setter($value);
            }
        }
    }

    /**
     * Route principale : /produits
     * Lit les données en base de données et affiche les produits
     */
    #[Route('/produits', name: 'app_product')]
    public function index(): Response
    {
        // 1. Récupérer les données de l'API
        $apiProducts = $this->fetchPrintfulData();

        if ($apiProducts) {
            // 2. Synchroniser si nécessaire
            $this->synchronizeProducts($apiProducts);
        }

        // 3. Récupérer les données de la base de données
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }


    /**
     * Route individuelle : /produits/{id}
     * Affiche les détails d'un produit spécifique.
     */
    #[Route('/produits/{id}', name: 'app_product_detail', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        // Récupérer le produit par son ID
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
