<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Producto2Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Zonas geográficas (catálogo base para comunidades y API REST)
        DB::table('zonas')->insert([
            ['id' => 1, 'nombre' => 'Centro', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Norte', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Sur', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Este', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Oeste', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Especialidades originales del Producto 2 (conservando precios base exactos)
        DB::table('especialidades')->insert([
            ['id' => 1, 'nombre_especialidad' => 'Fontanería', 'precio_base' => 60.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre_especialidad' => 'Electricidad', 'precio_base' => 65.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre_especialidad' => 'Climatización', 'precio_base' => 85.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Usuarios originales del Producto 2 + 1 usuario de prueba para empresa gestora
        DB::table('usuarios')->insert([
            ['id' => 2, 'nombre' => 'sasa1', 'email' => 'prueba123@gmail.com', 'password' => '$2y$10$jCrg5zcVypb3HajolGok8uPBt.QauvSZTQJ2zlFoAbhb0cHXC9biq', 'rol' => 'particular', 'telefono' => '112233', 'created_at' => '2026-11-01 11:50:48', 'updated_at' => '2026-11-01 11:50:48'],
            ['id' => 5, 'nombre' => 'admin', 'email' => 'admin@reparaya.com', 'password' => '$2y$10$YHtTDQEjxSIr.UCLmj/JD.VN7UD4hMBOtJNzfdjxW3s1TmcMyaOYK', 'rol' => 'admin', 'telefono' => '123456', 'created_at' => '2026-11-07 14:17:48', 'updated_at' => '2026-11-07 14:17:48'],
            ['id' => 6, 'nombre' => 'marco polo', 'email' => 'tecnico1@reparaya.com', 'password' => '$2y$10$bnXhv4Yv3Mgo4lg1tGaFO.PmdYPRG2Jjw4uTnIiyvpP63s.XDnOO6', 'rol' => 'tecnico', 'telefono' => null, 'created_at' => '2026-11-08 14:13:46', 'updated_at' => '2026-11-08 14:13:46'],
            ['id' => 7, 'nombre' => 'Andrea Pirlo', 'email' => 'tecnico2@reparaya.com', 'password' => '$2y$10$Fy0Pt8j5qOj6jEvqSPraWOrWTiuCZatGDGxPZbpPxB0mUZ/6t8ZM6', 'rol' => 'tecnico', 'telefono' => null, 'created_at' => '2026-11-08 16:34:49', 'updated_at' => '2026-11-08 16:34:49'],
            ['id' => 8, 'nombre' => 'Mario', 'email' => 'tecnico123@reparaya.com', 'password' => '$2y$10$WdtvQZCWX0MjIvwAC6KF2ubI7CTPc5EvVF/0rEOKDBLrk9v2g6W0m', 'rol' => 'tecnico', 'telefono' => null, 'created_at' => '2026-11-10 15:36:48', 'updated_at' => '2026-11-10 15:36:48'],
            ['id' => 9, 'nombre' => 'Francisco Totti', 'email' => 'totti@gmail.com', 'password' => '$2y$10$11ZlMBMh.N4REmMjYGUnCOhxuxG2k8PJtuPTaDB1D18u.cDwOCByS', 'rol' => 'particular', 'telefono' => '123321123', 'created_at' => '2026-11-16 21:30:49', 'updated_at' => '2026-11-16 21:30:49'],
            ['id' => 10, 'nombre' => 'Gestoría Fincas BCN', 'email' => 'gestora@reparaya.com', 'password' => Hash::make('123456'), 'rol' => 'gestora', 'telefono' => '930001122', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Técnicos originales del Producto 2
        DB::table('tecnicos')->insert([
            ['id' => 4, 'usuario_id' => 6, 'nombre_completo' => 'marco polo', 'especialidad_id' => 2, 'disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'usuario_id' => 7, 'nombre_completo' => 'Andrea Pirlo', 'especialidad_id' => 3, 'disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'usuario_id' => 8, 'nombre_completo' => 'Mario', 'especialidad_id' => 2, 'disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Empresa Gestora y Comunidades de prueba para B2B
        DB::table('empresas_gestoras')->insert([
            [
                'id' => 1,
                'usuario_id' => 10,
                'nombre_empresa' => 'Fincas Barcelona S.L.',
                'cif' => 'B12345678',
                'telefono' => '930001122',
                'porcentaje_comision' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('comunidades')->insert([
            [
                'id' => 1,
                'empresa_gestora_id' => 1,
                'zona_id' => 1,
                'nombre' => 'Comunidad Edificio Diagonal',
                'direccion' => 'Av. Diagonal 450, Barcelona',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'empresa_gestora_id' => 1,
                'zona_id' => 2,
                'nombre' => 'Residencial Gràcia Nord',
                'direccion' => 'Carrer Gran de Gràcia 120, Barcelona',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 6. Incidencias originales del Producto 2 (asignando zona_id = 1 por defecto para compatibilidad con la API REST)
        DB::table('incidencias')->insert([
            ['id' => 2, 'localizador' => 'REP-A8229BD4', 'cliente_id' => 2, 'tecnico_id' => 4, 'especialidad_id' => 2, 'comunidad_id' => null, 'zona_id' => 1, 'descripcion' => 'loremipsum loremipsumloremipsumloremipsumloremipsumloremipsumloremipsum', 'direccion' => 'pruebaprueba', 'fecha_servicio' => '2026-11-06 12:25:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Finalizada', 'created_at' => '2026-11-06 11:31:14', 'updated_at' => '2026-11-06 11:31:14'],
            ['id' => 3, 'localizador' => 'REP-9D4C93D4', 'cliente_id' => 2, 'tecnico_id' => 5, 'especialidad_id' => 2, 'comunidad_id' => null, 'zona_id' => 1, 'descripcion' => '123123321', 'direccion' => 'aaa', 'fecha_servicio' => '2026-11-07 13:36:00', 'tipo_urgencia' => 'Urgente', 'estado' => 'En curso', 'created_at' => '2026-11-06 12:36:36', 'updated_at' => '2026-11-06 12:36:36'],
            ['id' => 7, 'localizador' => 'REP-BBBEEC8E', 'cliente_id' => 2, 'tecnico_id' => 6, 'especialidad_id' => 3, 'comunidad_id' => null, 'zona_id' => 2, 'descripcion' => 'asdasdasd', 'direccion' => 'asdasd', 'fecha_servicio' => '2026-11-14 13:39:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Asignada', 'created_at' => '2026-11-06 12:44:43', 'updated_at' => '2026-11-06 12:44:43'],
            ['id' => 8, 'localizador' => 'REP-209564F9', 'cliente_id' => 2, 'tecnico_id' => 6, 'especialidad_id' => 2, 'comunidad_id' => null, 'zona_id' => 2, 'descripcion' => '21321321321', 'direccion' => 'asda213', 'fecha_servicio' => '2026-11-19 14:11:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Asignada', 'created_at' => '2026-11-06 13:11:37', 'updated_at' => '2026-11-06 13:11:37'],
            ['id' => 9, 'localizador' => 'REP-58515FF9', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 3, 'comunidad_id' => null, 'zona_id' => 1, 'descripcion' => 'admin incidencia', 'direccion' => 'incidencia 1 (admin)', 'fecha_servicio' => '2026-11-28 14:13:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Cancelada', 'created_at' => '2026-11-08 13:13:41', 'updated_at' => '2026-11-08 13:13:41'],
            ['id' => 10, 'localizador' => 'REP-9B601908', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 1, 'comunidad_id' => null, 'zona_id' => 3, 'descripcion' => 'ssddaa', 'direccion' => 'aa', 'fecha_servicio' => '2026-11-08 17:56:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Pendiente', 'created_at' => '2026-11-08 16:56:22', 'updated_at' => '2026-11-08 16:56:22'],
            ['id' => 11, 'localizador' => 'REP-9CE2F086', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 2, 'comunidad_id' => null, 'zona_id' => 3, 'descripcion' => 'qweqqq', 'direccion' => 'qwe', 'fecha_servicio' => '2026-11-08 17:56:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Pendiente', 'created_at' => '2026-11-08 16:56:46', 'updated_at' => '2026-11-08 16:56:46'],
            ['id' => 12, 'localizador' => 'REP-FCE7D61D', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 3, 'comunidad_id' => null, 'zona_id' => 4, 'descripcion' => '1232', 'direccion' => '123', 'fecha_servicio' => '2026-11-08 18:22:00', 'tipo_urgencia' => 'Urgente', 'estado' => 'Pendiente', 'created_at' => '2026-11-08 17:22:22', 'updated_at' => '2026-11-08 17:22:22'],
            ['id' => 13, 'localizador' => 'REP-FE47E816', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 3, 'comunidad_id' => null, 'zona_id' => 4, 'descripcion' => '1232', 'direccion' => '123', 'fecha_servicio' => '2026-11-08 18:22:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Pendiente', 'created_at' => '2026-11-08 17:22:44', 'updated_at' => '2026-11-08 17:22:44'],
            ['id' => 14, 'localizador' => 'REP-1722DD08', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 3, 'comunidad_id' => null, 'zona_id' => 5, 'descripcion' => 'aa', 'direccion' => 'aa', 'fecha_servicio' => '2026-11-08 18:29:00', 'tipo_urgencia' => 'Urgente', 'estado' => 'Pendiente', 'created_at' => '2026-11-08 17:29:22', 'updated_at' => '2026-11-08 17:29:22'],
            ['id' => 15, 'localizador' => 'REP-BD87C0D1', 'cliente_id' => 2, 'tecnico_id' => 6, 'especialidad_id' => 1, 'comunidad_id' => null, 'zona_id' => 5, 'descripcion' => '123213', 'direccion' => '123', 'fecha_servicio' => '2026-11-09 19:13:00', 'tipo_urgencia' => 'Urgente', 'estado' => 'Asignada', 'created_at' => '2026-11-08 18:13:44', 'updated_at' => '2026-11-08 18:13:44'],
            ['id' => 16, 'localizador' => 'REP-5B1810B1', 'cliente_id' => 2, 'tecnico_id' => null, 'especialidad_id' => 2, 'comunidad_id' => null, 'zona_id' => 1, 'descripcion' => '112233', 'direccion' => 'asdasd', 'fecha_servicio' => '2026-11-20 22:29:00', 'tipo_urgencia' => 'Estándar', 'estado' => 'Pendiente', 'created_at' => '2026-11-16 21:29:21', 'updated_at' => '2026-11-16 21:29:21'],
        ]);

        // 7. Historial de estados original del Producto 2
        DB::table('historial_estados')->insert([
            ['id' => 1, 'incidencia_id' => 7, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-06 12:44:43', 'observaciones' => null, 'created_at' => '2026-11-06 12:44:43', 'updated_at' => '2026-11-06 12:44:43'],
            ['id' => 2, 'incidencia_id' => 8, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-06 13:11:37', 'observaciones' => null, 'created_at' => '2026-11-06 13:11:37', 'updated_at' => '2026-11-06 13:11:37'],
            ['id' => 3, 'incidencia_id' => 8, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-06 17:39:48', 'observaciones' => null, 'created_at' => '2026-11-06 17:39:48', 'updated_at' => '2026-11-06 17:39:48'],
            ['id' => 4, 'incidencia_id' => 2, 'estado_anterior' => 'Asignada', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-07 18:31:47', 'observaciones' => null, 'created_at' => '2026-11-07 18:31:47', 'updated_at' => '2026-11-07 18:31:47'],
            ['id' => 5, 'incidencia_id' => 3, 'estado_anterior' => 'Asignada', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-07 18:32:14', 'observaciones' => null, 'created_at' => '2026-11-07 18:32:14', 'updated_at' => '2026-11-07 18:32:14'],
            ['id' => 6, 'incidencia_id' => 9, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 13:13:41', 'observaciones' => null, 'created_at' => '2026-11-08 13:13:41', 'updated_at' => '2026-11-08 13:13:41'],
            ['id' => 7, 'incidencia_id' => 7, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 13:16:17', 'observaciones' => null, 'created_at' => '2026-11-08 13:16:17', 'updated_at' => '2026-11-08 13:16:17'],
            ['id' => 8, 'incidencia_id' => 9, 'estado_anterior' => 'Asignada', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 13:16:20', 'observaciones' => null, 'created_at' => '2026-11-08 13:16:20', 'updated_at' => '2026-11-08 13:16:20'],
            ['id' => 9, 'incidencia_id' => 7, 'estado_anterior' => 'Asignada', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 13:16:24', 'observaciones' => null, 'created_at' => '2026-11-08 13:16:24', 'updated_at' => '2026-11-08 13:16:24'],
            ['id' => 10, 'incidencia_id' => 2, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 13:22:06', 'observaciones' => null, 'created_at' => '2026-11-08 13:22:06', 'updated_at' => '2026-11-08 13:22:06'],
            ['id' => 11, 'incidencia_id' => 3, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:06:41', 'observaciones' => null, 'created_at' => '2026-11-08 14:06:41', 'updated_at' => '2026-11-08 14:06:41'],
            ['id' => 12, 'incidencia_id' => 2, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:13:58', 'observaciones' => null, 'created_at' => '2026-11-08 14:13:58', 'updated_at' => '2026-11-08 14:13:58'],
            ['id' => 13, 'incidencia_id' => 3, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:17:20', 'observaciones' => null, 'created_at' => '2026-11-08 14:17:20', 'updated_at' => '2026-11-08 14:17:20'],
            ['id' => 14, 'incidencia_id' => 7, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:17:43', 'observaciones' => null, 'created_at' => '2026-11-08 14:17:43', 'updated_at' => '2026-11-08 14:17:43'],
            ['id' => 15, 'incidencia_id' => 8, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:17:45', 'observaciones' => null, 'created_at' => '2026-11-08 14:17:45', 'updated_at' => '2026-11-08 14:17:45'],
            ['id' => 16, 'incidencia_id' => 9, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:17:47', 'observaciones' => null, 'created_at' => '2026-11-08 14:17:47', 'updated_at' => '2026-11-08 14:17:47'],
            ['id' => 17, 'incidencia_id' => 2, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 14:22:58', 'observaciones' => null, 'created_at' => '2026-11-08 14:22:58', 'updated_at' => '2026-11-08 14:22:58'],
            ['id' => 18, 'incidencia_id' => 2, 'estado_anterior' => 'Asignada', 'estado_nuevo' => 'En curso', 'usuario_id' => 6, 'fecha_cambio' => '2026-11-08 14:37:27', 'observaciones' => null, 'created_at' => '2026-11-08 14:37:27', 'updated_at' => '2026-11-08 14:37:27'],
            ['id' => 19, 'incidencia_id' => 2, 'estado_anterior' => 'En curso', 'estado_nuevo' => 'Finalizada', 'usuario_id' => 6, 'fecha_cambio' => '2026-11-08 14:38:22', 'observaciones' => null, 'created_at' => '2026-11-08 14:38:22', 'updated_at' => '2026-11-08 14:38:22'],
            ['id' => 20, 'incidencia_id' => 10, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-08 16:56:22', 'observaciones' => null, 'created_at' => '2026-11-08 16:56:22', 'updated_at' => '2026-11-08 16:56:22'],
            ['id' => 21, 'incidencia_id' => 11, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-08 16:56:46', 'observaciones' => null, 'created_at' => '2026-11-08 16:56:46', 'updated_at' => '2026-11-08 16:56:46'],
            ['id' => 22, 'incidencia_id' => 12, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 17:22:22', 'observaciones' => null, 'created_at' => '2026-11-08 17:22:22', 'updated_at' => '2026-11-08 17:22:22'],
            ['id' => 23, 'incidencia_id' => 13, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 17:22:44', 'observaciones' => null, 'created_at' => '2026-11-08 17:22:44', 'updated_at' => '2026-11-08 17:22:44'],
            ['id' => 24, 'incidencia_id' => 14, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 17:29:22', 'observaciones' => null, 'created_at' => '2026-11-08 17:29:22', 'updated_at' => '2026-11-08 17:29:22'],
            ['id' => 25, 'incidencia_id' => 3, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-08 17:31:54', 'observaciones' => null, 'created_at' => '2026-11-08 17:31:54', 'updated_at' => '2026-11-08 17:31:54'],
            ['id' => 26, 'incidencia_id' => 9, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Cancelada', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-08 17:53:00', 'observaciones' => null, 'created_at' => '2026-11-08 17:53:00', 'updated_at' => '2026-11-08 17:53:00'],
            ['id' => 27, 'incidencia_id' => 15, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-08 18:13:44', 'observaciones' => null, 'created_at' => '2026-11-08 18:13:44', 'updated_at' => '2026-11-08 18:13:44'],
            ['id' => 28, 'incidencia_id' => 3, 'estado_anterior' => 'Asignada', 'estado_nuevo' => 'En curso', 'usuario_id' => 7, 'fecha_cambio' => '2026-11-10 15:35:04', 'observaciones' => null, 'created_at' => '2026-11-10 15:35:04', 'updated_at' => '2026-11-10 15:35:04'],
            ['id' => 29, 'incidencia_id' => 8, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-10 15:37:11', 'observaciones' => null, 'created_at' => '2026-11-10 15:37:11', 'updated_at' => '2026-11-10 15:37:11'],
            ['id' => 30, 'incidencia_id' => 7, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-10 15:37:24', 'observaciones' => null, 'created_at' => '2026-11-10 15:37:24', 'updated_at' => '2026-11-10 15:37:24'],
            ['id' => 31, 'incidencia_id' => 15, 'estado_anterior' => 'Pendiente', 'estado_nuevo' => 'Asignada', 'usuario_id' => 5, 'fecha_cambio' => '2026-11-10 15:37:27', 'observaciones' => null, 'created_at' => '2026-11-10 15:37:27', 'updated_at' => '2026-11-10 15:37:27'],
            ['id' => 32, 'incidencia_id' => 16, 'estado_anterior' => null, 'estado_nuevo' => 'Pendiente', 'usuario_id' => 2, 'fecha_cambio' => '2026-11-16 21:29:21', 'observaciones' => null, 'created_at' => '2026-11-16 21:29:21', 'updated_at' => '2026-11-16 21:29:21'],
        ]);
    }
}