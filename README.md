Роуты:

1) Разработчики:
    

    1.1) "/developer" POST - создаёт пользователя.\ 
    Пример полей: {"fullName": "Алексеев Алексей Алексеевич", "post": "junior tester", "phone": "79999999999", "email": "email@gmail.com","project": null,"age": 30}\
    
    1.2) "/developers" GET - возвращает всех пользователей с их проектами\
    
    1.3) "/developer/{id}" DELETE - удаляет пользователя по ID
    
    1.4) "/developer/{developerId}/transfer/{projectId}" PUT - переводит пользователя на проект


2) Проекты:
    

    2.1) "/project" POST - создаёт проект.\
    Пример полей: { "customer": "Иванов Иван Иванович", "name": "Абибас красовки"}
    
    2.2) "/projects" GET - возвращает все проекты с их разработчиками

    2.3) "/project/{id}" DELETE - удаляет проект по ID
   
    2.4) "/project/{id}/close" PUT - закрывает проект по ID


3) Статистика:


    3.1) "/statistic/project/count" GET - возвращает кол-во проектов

    3.2) "/statistic/project/count/customer/{name}" GET - возвращает кол-во проектов заказчика
 
    3.3) "/statistics/developers/average_age" GET - возвращает средний возраст разработчиков

    3.4) "/statistics/developers/count" GET - возвращает кол-во разработчиков