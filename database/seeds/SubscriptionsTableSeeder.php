<?php

use Illuminate\Database\Seeder;

use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanFeature;

class SubscriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
	     Plan::truncate();
	     PlanFeature::truncate();

	    $plan = Plan::create([
		    'slug' => 'basic',
		    'name' => 'BASIC',
		    'description' => 'Бесплатно',
		    'price' => 0,
		    'signup_fee' => 0,
		    'invoice_period' => 0,
		    'invoice_interval' => 'month',
		    'trial_period' => 0,
		    'trial_interval' => 'day',
		    'sort_order' => 1,
		    'currency' => 'UAH',
	    ]);



	    // Create multiple plan features at once
	    $plan->features()->saveMany([
		    new PlanFeature(['slug' => 'tms_control_profile__1','name' => 'Профиль на сервисе', 'value' => 1, 'sort_order' => 1]),
		    new PlanFeature(['slug' => 'tms_control_company__1','name' => 'Информация о компании', 'value' => 1, 'sort_order' => 2]),
		    new PlanFeature(['slug' => 'tms_control_partners__1','name' => 'Добавление и просмотр партнеров', 'value' => 1, 'sort_order' => 4]),
		    new PlanFeature(['slug' => 'tms_control_testimonial__1','name' => 'Отзывы', 'value' => 1, 'sort_order' => 5]),
		    new PlanFeature(['slug' => 'tms_control_requests_from_clients__1','name' => 'Получение прямых заказов от клиентов на свой транспорт', 'value' => 1, 'sort_order' => 6]),
		    new PlanFeature(['slug' => 'tms_control_order_progress__1','name' => 'Отслеживание прогресса выполнения заказов', 'value' => 1, 'sort_order' => 7]),
		    new PlanFeature(['slug' => 'tms_control_transports__1','name' => 'Управление транспортом', 'value' => 1, 'sort_order' => 8]),
		    new PlanFeature(['slug' => 'tms_control_app_gps__1','name' => 'Отслеживание местоположения через APP и GPS', 'value' => 1, 'sort_order' => 9]),
		    new PlanFeature(['slug' => 'tms_control_doc_e__1','name' => 'Управление электронным документооборотом', 'value' => 1, 'sort_order' => 10]),
		    new PlanFeature(['slug' => 'tms_control_doc_templates__1','name' => 'Шаблоны документов', 'value' => 1, 'sort_order' => 11]),
		    new PlanFeature(['slug' => 'tms_control_doc_auto_creating__1','name' => 'Автоматическое созздание необходимых документов к заказу', 'value' => 1, 'sort_order' => 11]),
		    new PlanFeature(['slug' => 'tms_control_clients__1','name' => 'Добавление клиентов и отправка приглашений', 'value' => 1, 'sort_order' => 12]),
		    new PlanFeature(['slug' => 'tms_control_clients_tracking__1','name' => 'Просмотр клиентом своего заказа и местонахождение груза в личном кабинете', 'value' => 1, 'sort_order' => 13]),
		    new PlanFeature(['slug' => 'tms_control_analytics_company__1','name' => 'Аналитика ключевых показателей компании и отчетность', 'value' => 1, 'sort_order' => 14]),
	    ]);

	    $plan = Plan::create([
		    'slug' => 'individual',
		    'name' => 'INDIVIDUAL',
		    'description' => 'за 1 авто',
		    'price' => 80,
		    'signup_fee' => 80, // это зачеркнуто
		    'invoice_period' => 1,
		    'invoice_interval' => 'month',
		    'trial_period' => 0,
		    'trial_interval' => 'day',
		    'sort_order' => 2,
		    'currency' => 'UAH',
	    ]);

	    // Create multiple plan features at once
	    $plan->features()->saveMany([
		    new PlanFeature(['slug' => 'tms_control_profile__2','name' => 'Профиль на сервисе', 'value' => 1, 'sort_order' => 1]),
		    new PlanFeature(['slug' => 'tms_control_company__2','name' => 'Информация о компании', 'value' => 1, 'sort_order' => 2]),
		    new PlanFeature(['slug' => 'tms_control_partners__2','name' => 'Добавление и просмотр партнеров', 'value' => 1, 'sort_order' => 3]),
		    new PlanFeature(['slug' => 'tms_control_testimonial__2','name' => 'Отзывы', 'value' => 1, 'sort_order' => 4]),
		    new PlanFeature(['slug' => 'tms_control_requests_from_clients__2','name' => 'Получение прямых заказов от клиентов на свой транспорт', 'value' => 1, 'sort_order' => 5]),
		    new PlanFeature(['slug' => 'tms_control_order_creating__2','name' => 'Самостоятельное оформление нового заказа перевозчиком', 'value' => 1, 'sort_order' => 6]),
		    new PlanFeature(['slug' => 'tms_control_order__2','name' => 'Управление заказами. Просмотр, изменение, передача на партнера', 'value' => 1, 'sort_order' => 7]),
		    new PlanFeature(['slug' => 'tms_control_order_progress__2','name' => 'Отслеживание прогресса выполнения заказов', 'value' => 1, 'sort_order' => 8]),
		    new PlanFeature(['slug' => 'tms_control_transports__2','name' => 'Управление транспортом', 'value' => 1, 'sort_order' => 9]),
		    new PlanFeature(['slug' => 'tms_control_app_gps__2','name' => 'Отслеживание местоположения через APP и GPS', 'value' => 1, 'sort_order' => 10]),
		    new PlanFeature(['slug' => 'tms_control_doc_e__2','name' => 'Управление электронным документооборотом', 'value' => 1, 'sort_order' => 11]),
		    new PlanFeature(['slug' => 'tms_control_doc_templates__2','name' => 'Шаблоны документов', 'value' => 1, 'sort_order' => 12]),
		    new PlanFeature(['slug' => 'tms_control_doc_auto_creating__2','name' => 'Автоматическое созздание необходимых документов к заказу', 'value' => 1, 'sort_order' => 13]),
		    new PlanFeature(['slug' => 'tms_control_clients__2','name' => 'Добавление клиентов и отправка приглашений', 'value' => 1, 'sort_order' => 14]),
		    new PlanFeature(['slug' => 'tms_control_clients_tracking__2','name' => 'Просмотр клиентом своего заказа и местонахождение груза в личном кабинете', 'value' => 1, 'sort_order' => 15]),
		    new PlanFeature(['slug' => 'tms_control_analytics_company__2','name' => 'Аналитика ключевых показателей компании и отчетность', 'value' => 1, 'sort_order' => 16]),
	    ]);

	    $plan = Plan::create([
		    'slug' => 'pro',
		    'name' => 'PRO',
		    'description' => 'за 1 авто',
		    'price' => 200,
		    'signup_fee' => 200, // это зачеркнуто
		    'invoice_period' => 1,
		    'invoice_interval' => 'month',
		    'trial_period' => 0,
		    'trial_interval' => 'day',
		    'sort_order' => 3,
		    'currency' => 'UAH',
	    ]);

	    // Create multiple plan features at once
	    $plan->features()->saveMany([
		    new PlanFeature(['slug' => 'tms_control_profile__3','name' => 'Профиль на сервисе', 'value' => 1, 'sort_order' => 1]),
		    new PlanFeature(['slug' => 'tms_control_company__3','name' => 'Информация о компании', 'value' => 1, 'sort_order' => 2]),
		    new PlanFeature(['slug' => 'tms_control_staff__3','name' => 'Управление сотрудниками', 'value' => 1, 'sort_order' => 3]),
		    new PlanFeature(['slug' => 'tms_control_partners__3','name' => 'Добавление и просмотр партнеров', 'value' => 1, 'sort_order' => 4]),
		    new PlanFeature(['slug' => 'tms_control_testimonial__3','name' => 'Отзывы', 'value' => 1, 'sort_order' => 5]),
		    new PlanFeature(['slug' => 'tms_control_requests_from_clients__3','name' => 'Получение прямых заказов от клиентов на свой транспорт', 'value' => 1, 'sort_order' => 6]),
		    new PlanFeature(['slug' => 'tms_control_partners_price__3','name' => 'Возможность передачи заказа на партнера с указанием своей цены', 'value' => 1, 'sort_order' => 7]),
		    new PlanFeature(['slug' => 'tms_control_order_creating__3','name' => 'Самостоятельное оформление нового заказа перевозчиком', 'value' => 1, 'sort_order' => 8]),
		    new PlanFeature(['slug' => 'tms_control_order__3','name' => 'Управление заказами. Просмотр, изменение, передача на партнера', 'value' => 1, 'sort_order' => 9]),
		    new PlanFeature(['slug' => 'tms_control_order_progress__3','name' => 'Отслеживание прогресса выполнения заказов', 'value' => 1, 'sort_order' => 10]),
		    new PlanFeature(['slug' => 'tms_control_transports__3','name' => 'Управление транспортом', 'value' => 1, 'sort_order' => 11]),
		    new PlanFeature(['slug' => 'tms_control_transports_search__3','name' => 'Автоматический подбор подходящего транспорта на заказ', 'value' => 1, 'sort_order' => 12]),
		    new PlanFeature(['slug' => 'tms_control_app_gps__3','name' => 'Отслеживание местоположения через APP и GPS', 'value' => 1, 'sort_order' => 13]),
		    new PlanFeature(['slug' => 'tms_control_doc_e__3','name' => 'Управление электронным документооборотом', 'value' => 1, 'sort_order' => 14]),
		    new PlanFeature(['slug' => 'tms_control_doc_templates__3','name' => 'Шаблоны документов', 'value' => 1, 'sort_order' => 15]),
		    new PlanFeature(['slug' => 'tms_control_doc_auto_creating__3','name' => 'Автоматическое создание необходимых документов к заказу', 'value' => 1, 'sort_order' => 16]),
		    new PlanFeature(['slug' => 'tms_control_staff_manager__3','name' => 'Управление менеджерами через их личные кабинеты', 'value' => 1, 'sort_order' => 17]),
		    new PlanFeature(['slug' => 'tms_control_staff_driver__3','name' => 'Управление и контроль водителей', 'value' => 1, 'sort_order' => 18]),
		    new PlanFeature(['slug' => 'tms_control_staff_driver_stat__3','name' => 'Отчетность водителей через приложение', 'value' => 1, 'sort_order' => 19]),
		    new PlanFeature(['slug' => 'tms_control_1с__3','name' => 'Интеграция с 1С', 'value' => 1, 'sort_order' => 20]),
		    new PlanFeature(['slug' => 'tms_control_clients__3','name' => 'Добавление клиентов и отправка приглашений', 'value' => 1, 'sort_order' => 21]),
		    new PlanFeature(['slug' => 'tms_control_clients_tracking__3','name' => 'Просмотр клиентом своего заказа и местонахождение груза в личном кабинете', 'value' => 1, 'sort_order' => 22]),
		    new PlanFeature(['slug' => 'tms_control_analytics_company__3','name' => 'Аналитика ключевых показателей компании и отчетность', 'value' => 1, 'sort_order' => 23]),
		    new PlanFeature(['slug' => 'tms_control_analytics_deal__3','name' => 'Аналитика по сделкам', 'value' => 1, 'sort_order' => 24]),
		    new PlanFeature(['slug' => 'tms_control_analytics_logist__3','name' => 'Аналитика по менеджерам логистам', 'value' => 1, 'sort_order' => 25]),
		    new PlanFeature(['slug' => 'tms_control_analytics_driver__3','name' => 'Аналитика по водителям', 'value' => 1, 'sort_order' => 26]),
	    ]);


	    $plan = Plan::create([
		    'slug' => 'enterprise',
		    'name' => 'ENTERPRISE',
		    'description' => 'custom',
		    'price' => 0,
		    'signup_fee' => 0,
		    'invoice_period' => 1,
		    'invoice_interval' => 'month',
		    'trial_period' => 0,
		    'trial_interval' => 'day',
		    'sort_order' => 4,
		    'currency' => 'UAH',
	    ]);

	    // Create multiple plan features at once
	    $plan->features()->saveMany([
		    new PlanFeature(['slug' => 'tms_control_profile__4','name' => 'Профиль на сервисе', 'value' => 1, 'sort_order' => 1]),
		    new PlanFeature(['slug' => 'tms_control_company__4','name' => 'Информация о компании', 'value' => 1, 'sort_order' => 2]),
		    new PlanFeature(['slug' => 'tms_control_company_department__4','name' => 'Добавление отделов и филиалов', 'value' => 1, 'sort_order' => 3]),
		    new PlanFeature(['slug' => 'tms_control_staff__4','name' => 'Управление сотрудниками', 'value' => 1, 'sort_order' => 4]),
		    new PlanFeature(['slug' => 'tms_control_partners__4','name' => 'Добавление и просмотр партнеров', 'value' => 1, 'sort_order' => 5]),
		    new PlanFeature(['slug' => 'tms_control_testimonial__4','name' => 'Отзывы', 'value' => 1, 'sort_order' => 6]),
		    new PlanFeature(['slug' => 'tms_control_requests_from_clients__4','name' => 'Получение прямых заказов от клиентов на свой транспорт', 'value' => 1, 'sort_order' => 7]),
		    new PlanFeature(['slug' => 'tms_control_partners_price__4','name' => 'Возможность передачи заказа на партнера с указанием своей цены', 'value' => 1, 'sort_order' => 8]),
		    new PlanFeature(['slug' => 'tms_control_order_creating__4','name' => 'Самостоятельное оформление нового заказа перевозчиком', 'value' => 1, 'sort_order' => 9]),
		    new PlanFeature(['slug' => 'tms_control_order__4','name' => 'Управление заказами. Просмотр, изменение, передача на партнера', 'value' => 1, 'sort_order' => 10]),
		    new PlanFeature(['slug' => 'tms_control_order_progress__4','name' => 'Отслеживание прогресса выполнения заказов', 'value' => 1, 'sort_order' => 11]),
		    new PlanFeature(['slug' => 'tms_control_transports__4','name' => 'Управление транспортом', 'value' => 1, 'sort_order' => 12]),
		    new PlanFeature(['slug' => 'tms_control_transports_search__4','name' => 'Автоматический подбор подходящего транспорта на заказ', 'value' => 1, 'sort_order' => 13]),
		    new PlanFeature(['slug' => 'tms_control_app_gps__4','name' => 'Отслеживание местоположения через APP и GPS', 'value' => 1, 'sort_order' => 14]),
		    new PlanFeature(['slug' => 'tms_control_doc_e__4','name' => 'Управление электронным документооборотом', 'value' => 1, 'sort_order' => 15]),
		    new PlanFeature(['slug' => 'tms_control_doc_templates__4','name' => 'Шаблоны документов', 'value' => 1, 'sort_order' => 16]),
		    new PlanFeature(['slug' => 'tms_control_doc_auto_creating__4','name' => 'Автоматическое созздание необходимых документов к заказу', 'value' => 1, 'sort_order' => 17]),
		    new PlanFeature(['slug' => 'tms_control_staff_manager__4','name' => 'Управление менеджерами через их личные кабинеты', 'value' => 1, 'sort_order' => 18]),
		    new PlanFeature(['slug' => 'tms_control_staff_driver__4','name' => 'Управление и контроль водителей', 'value' => 1, 'sort_order' => 19]),
		    new PlanFeature(['slug' => 'tms_control_staff_driver_stat__4','name' => 'Отчетность водителей через приложение', 'value' => 1, 'sort_order' => 20]),
		    new PlanFeature(['slug' => 'tms_control_1с__4','name' => 'Интеграция с 1С', 'value' => 1, 'sort_order' => 21]),
		    new PlanFeature(['slug' => 'tms_control_clients__4','name' => 'Добавление клиентов и отправка приглашений', 'value' => 1, 'sort_order' => 22]),
		    new PlanFeature(['slug' => 'tms_control_clients_tracking__4','name' => 'Просмотр клиентом своего заказа и местонахождение груза в личном кабинете', 'value' => 1, 'sort_order' => 23]),
		    new PlanFeature(['slug' => 'tms_control_analytics_company__4','name' => 'Аналитика ключевых показателей компании и отчетность', 'value' => 1, 'sort_order' => 24]),
		    new PlanFeature(['slug' => 'tms_control_analytics_deal__4','name' => 'Аналитика по сделкам', 'value' => 1, 'sort_order' => 25]),
		    new PlanFeature(['slug' => 'tms_control_analytics_logist__4','name' => 'Аналитика по менеджерам логистам', 'value' => 1, 'sort_order' => 26]),
		    new PlanFeature(['slug' => 'tms_control_analytics_driver__4','name' => 'Аналитика по водителям', 'value' => 1, 'sort_order' => 27]),
		    new PlanFeature(['slug' => 'tms_control_additional__4','name' => 'Разработка дополнительного функционала в соответствии с бизнес-процессами', 'value' => 1, 'sort_order' => 28]),
	    ]);

        

//        \DB::table('subscriptions')->delete();
//
//        \DB::table('subscriptions')->insert(array (
//            0 =>
//            array (
//                'id' => 1,
//                'name' => 'INN.LOGIST BASIC',
//                'type' => 'free',
//                'position' => 'low',
//                'price' => 0.0,
//                'min' => 1,
//                'limit' => 2,
//                'created_at' => '2018-09-28 09:40:53',
//                'updated_at' => '2018-09-28 09:40:53',
//            ),
//            1 =>
//            array (
//                'id' => 2,
//                'name' => 'INN.LOGIST PRO',
//                'type' => 'paid',
//                'position' => 'middle',
//                'price' => 200.0,
//                'min' => 5,
//                'limit' => 50,
//                'created_at' => '2018-09-28 09:42:32',
//                'updated_at' => '2018-09-28 09:42:32',
//            ),
//            2 =>
//            array (
//                'id' => 3,
//                'name' => 'INN.LOGIST ENTERPRISE',
//                'type' => 'paid',
//                'position' => 'top',
//                'price' => 1000.0,
//                'min' => 5,
//                'limit' => 0,
//                'created_at' => '2018-09-28 09:42:22',
//                'updated_at' => '2018-09-28 09:42:22',
//            ),
//        ));
        
        
    }
}