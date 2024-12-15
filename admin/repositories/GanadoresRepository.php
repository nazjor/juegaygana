<?php
// Repositorio de Ganadores (GanadoresRepository.php)

class GanadoresRepository {
    public function obtenerGanadores() {
        return [
            [
                'nombre' => 'Juan Pérez',
                'cedula' => '12345678',
                'boleto' => '4200',
                'premio' => 'Casa',
                'fecha' => '2024-12-10',
                'foto' => 'https://img-s-msn-com.akamaized.net/tenant/amp/entityid/AA1sFVQ3.img?w=640&h=360&m=6' // Imagen ejemplo
            ],
            [
                'nombre' => 'María Gómez',
                'cedula' => '23456789',
                'boleto' => '1022',
                'premio' => 'Carro AVEO',
                'fecha' => '2024-12-11',
                'foto' => 'https://juegayganaconmanolo.com/admin/assets/images/products/rifa_675d67a0963d3.jpeg' // Imagen ejemplo
            ],
            [
                'nombre' => 'Carlos Sánchez',
                'cedula' => '34567890',
                'boleto' => '0023',
                'premio' => 'Moto',
                'fecha' => '2024-12-12',
                'foto' => 'https://img.redbull.com/images/c_crop,w_3840,h_1920,x_0,y_0/c_auto,w_1200,h_630/f_auto,q_auto/redbullcom/2024/11/17/bxpd3oeqp85zsyloadbl/jorge-martin-2024-motogp-campeon-del-mundo-2024'
            ],
        ];
    }
}
?>
