<?php
	declare(strict_types=1);

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends CI_Controller {

		public function index(): void
		{

			Factory_helper::delete('role_model', ['id>' => 0]);

			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));

			$data = [
				'active' => '1',
				'role' => 'root',
			];

			$id = Factory_helper::create('role_model', $data);

			Factory_helper::fetchAndSet('role_model', $id);


			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));
			var_dump(Factory_helper::delete('role_model', ['id>' => 0]));
			$object2 = Factory_helper::fetchAndSet('role_model', Factory_helper::create('role_model', $data));
			var_dump($object2);
			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));
			Factory_helper::delete('role_model', ['id>' => 0]);
			$object3 = Factory_helper::fetchAndSet('role_model', Factory_helper::create('role_model', $data), ['role']);			
			var_dump($object3);
			// var_dump($object3->id);

			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));
			var_dump(Factory_helper::delete('role_model', $object3->id));
			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));


			$data =  [
				[
					'active' => '1',
					'role' => 'root',
				],
				[
					'active' => '1',
					'role' => 'admin',
				],
				[
					'active' => '1',
					'role' => 'employee',
				],
				[
					'active' => '1',
					'role' => 'buyer',
				],
				[
					'active' => '1',
					'role' => '<script>buyer',
				]
			];

			var_dump(Factory_helper::multipleCreate('role_model', $data));
			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));

			$data =  [
				[
					'active' => '0',
					'role' => 'root',
				],
				[
					'active' => '0',
					'role' => 'admin',
				],
				[
					'active' => '0',
					'role' => 'employee',
				],
				[
					'active' => '0',
					'role' => 'buyer',
				],
				[
					'active' => '0',
					'role' => '<script>buyer',
				]
			];

			var_dump(Factory_helper::insertOnDuplicateKeyUpdate('role_model', $data));
			var_dump(Factory_helper::readImproved('role_model', ['what' => ['*']]));

			die();
			return;
		}
	}
