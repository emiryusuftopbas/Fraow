## Fraow

This app brings together users social media accounts and contact addresses and profile them.

I coded this project during the first term time of the year when I started university.

The database of the project was deleted, I re-created it by looking at the codes.

## Used Libraries

- PHPMailer

- Bulma css

- Jquery 

- Croppie 

- Sweetalert 

- Jquery mask



## How to run

You need php to run this project.

- Clone this Project 

``` 
git clone https://github.com/emiryusuftopbas/Fraow.git
```

- Create database and import fraow.sql
- Change the config.php file that located in the core folder

 You are ready to run Fraow.

## File structure

- assets
  - images 
  - profileimages
  - scripts
  - stylesheets
- core
  - classes
- view
  - dashboard
  - page
- index.php
- profile.php
- .htaccess 

### Assets folder

In the assets folder we have scripts stylesheets and images.

### Core folder

In the core folder there are php scripts that we send post request from client side using ajax. 

Also there are functions.php file that we defined our functions and there are config.php file for database and mail server configuration.

### View folder

In the view folder we have our view files we include them in our index.php file.

### Index.php file

There is a routing system in the index.php file and we include our pages according to the changing url information.

*Example :* If we go example.com/settings page , routing system calls a function named settings.

```php
function settings($par,$db){
		$dashboardSettings = 'view/dashboard/settings.php';
		if (session('loginsession')) {
			$dashboard=null;
		    require_once $dashboardSettings;
		}
	}
```



## Available social networks

![available social networks](https://user-images.githubusercontent.com/58172827/76172239-ccfec180-61a4-11ea-8213-c520d0b887f7.PNG)

You need add available social networks manually.  

There are two *asn_type* value contactinfo and socialmedia. 

![Profile section](https://user-images.githubusercontent.com/58172827/76896613-37012000-68a3-11ea-81e0-901441ce388a.png)

Users only can add available social network profile links to their profile.

mobilephone , homephone , whatsapp , email and website are pre defined social network types , there must be in the available_social_networks table and also in the *addsociallink.php* we have special control for them. There are input masks for them in the *main.js* file.

**asn_url :** This column is very important. While adding social links users can type their social media profile link's url or username. Fraow parses the url using asn_url value.

**asn_status :** 1 for active, 0 for passive.

## Screenshots of Fraow

<img src="https://user-images.githubusercontent.com/58172827/76171967-14d01980-61a2-11ea-91e9-4a19c4e9477f.PNG" width="45%"></img> <img src="https://user-images.githubusercontent.com/58172827/76171983-2e716100-61a2-11ea-87bb-c74193d1e133.PNG" width="45%"></img> <img src="https://user-images.githubusercontent.com/58172827/76171989-41843100-61a2-11ea-9ec5-bf4b8d0ee33b.PNG" width="45%"></img> <img src="https://user-images.githubusercontent.com/58172827/76171999-4fd24d00-61a2-11ea-8e31-845add5a3601.png" width="45%"></img> <img src="https://user-images.githubusercontent.com/58172827/76172004-5365d400-61a2-11ea-9f73-e66282161160.PNG" width="45%"></img> <img src="https://user-images.githubusercontent.com/58172827/76171977-29acad00-61a2-11ea-90fb-61973a7100f1.PNG" width="45%"></img> 



## Database tables

![database-diagram](https://user-images.githubusercontent.com/58172827/76172081-19e19880-61a3-11ea-96fa-9416b0c41422.PNG)

## Contributors

 - Emir Yusuf TOPBAŞ <emiryusuftopbas@gmail.com>
## License & copyright
Licensed under the [MIT License](LICENSE)
