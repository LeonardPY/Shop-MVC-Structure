<?php

class ProductService
{
    public function makeProductData(?string $imagePath = null): array
    {
        $name = $_POST['name'];
        $description = $_POST['description'] ;
        $price = $_POST['price'];

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $imagePath
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $imagePath = basename($image['name']);
            $targetPath = __DIR__ . '/../images/' . $imagePath;
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $data['image'] = $imagePath;
            }
        }
        return $data;
    }
}