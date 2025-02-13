const express = require('express');
const bodyParser = require('body-parser');
const { Pool } = require('pg');

const app = express();
app.use(bodyParser.json());

// Configuración de la conexión a la base de datos PostgreSQL
const pool = new Pool({
    user: 'postgres',
    host: '127.0.0.1',
    database: 'FOSPUCA',
    password: 'Zuleta99@',
    port: '5432',
});

app.post('/api/dispositivos', async (req, res) => {
    const { imei, modelo, marca, fechaCompra, estado, placa, numeroUnidad, fechaInstalacion, estadoOperativo, motivoNoOperativo } = req.body;
    try {
        const result = await pool.query(
            `INSERT INTO dispositivos_gps (imei, modelo, marca, fecha_compra, estado, placa, numero_unidad, fecha_instalacion, estado_operativo, motivo_no_operativo) 
             VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)`,
            [imei, modelo, marca, fechaCompra, estado, placa, numeroUnidad, fechaInstalacion, estadoOperativo, motivoNoOperativo]
        );
        res.json({ message: 'Dispositivo registrado con éxito' });
    } catch (error) {
        console.error('Error al registrar dispositivo', error);
        res.status(500).json({ message: 'Error al registrar dispositivo' });
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Servidor corriendo en el puerto ${PORT}`);
});
