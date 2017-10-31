<?php

namespace Tests\AppBundle\Entity;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Product;

class ProductTest extends TestCase {

	public function pricesForFoodProduct() {
		return [
			[0, 0.0],
			[20, 1.1],
			[100, 5.5]
		];
	}

	/**
	 * @dataProvider pricesForFoodProduct
	 */
	 public function testComputeTVAFood ($price, $tva) {
		$product = new Product('Un produit', Product::FOOD_PRODUCT, $price);

		$this->assertSame($tva, $product->computeTVA());
		/* assertSame() est une classe de TestCase qui prends deux parametres :
		- Le resultat attendu : passé en parametre par $tva
		- La fonction à tester : computeTVA() sur $product */
	}

	public function testComputeTVANotFood () {
		$product = new Product('Oneplus 5', 'Mobile phone', 500);

		$this->assertSame(98.0, $product->computeTVA());
		// 500 * 0.196 = 98.0 et non pas 98 car price est un decimal
	}

	public function testComputeTVANegative () {
		$product = new Product('Error', 'Error', -1);

		$this->expectException('LogicException');
		// Exception attendue : 'LogicException'

		$product->computeTVA();
		// Execution du code, si l'exception attendu est levé tout va bien. Sinon test echoué.
	}
}