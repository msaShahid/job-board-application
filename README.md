# Laravel 11 API Project

Welcome to the Laravel 11 API Project! This project provides a RESTful API for user authentication and job management. This README will guide you through setting up, configuring, and using the API.

## Table of Contents

- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)


## Introduction

This project offers a comprehensive API built with Laravel 11, covering user authentication and job management features.

## Prerequisites

Ensure you have the following installed:

- **PHP 8.1+**
- **Composer**
- **MySQL** 


## Installation

1. **Clone the Repository**

   
   git clone https://github.com/msaShahid/job-board-application.git
   cd your-project-name
   

2. **Install Dependencies**

   composer install

3. **Create and Configure Environment File**

   cp .env.example .env

4. **Generate Application Key**

   php artisan key:generate

5. **Set Up the Database**

   Configure your database settings in the `.env` file and run migrations:
   
   php artisan migrate
   
## Configuration

Update the `.env` file with your environment-specific settings. You can also adjust application settings in the `config` directory.

## Usage

To start the development server:

php artisan serve

Access the API at `http://localhost:8000`.

## API Endpoints

### Authentication

- **Register**
  - **Endpoint:** `POST /api/v1/auth/register`
  - **Description:** Register a new user.
  - **Parameters:** `name`, `email`, `password`, `password_confirmation`
  - **Response:** User details and authentication token.

- **Login**
  - **Endpoint:** `POST /api/v1/auth/login`
  - **Description:** Authenticate a user and return a token.
  - **Parameters:** `email`, `password`
  - **Response:** Authentication token.

- **Get User**
  - **Endpoint:** `GET /api/v1/auth/user`
  - **Description:** Retrieve details of the authenticated user.
  - **Response:** User details.

- **Logout**
  - **Endpoint:** `POST /api/v1/auth/logout`
  - **Description:** Log out the authenticated user and invalidate the token.
  - **Response:** Success message.

### Work

- **Search Work**
  - **Endpoint:** `GET /api/v1/work/search`
  - **Description:** Search for work opportunities.
  - **Response:** List of work opportunities based on search criteria.

- **List Work**
  - **Endpoint:** `GET /api/v1/work`
  - **Description:** Retrieve a list of all work opportunities.
  - **Response:** List of work opportunities.

- **Create Work**
  - **Endpoint:** `POST /api/v1/work`
  - **Description:** Create a new work opportunity.
  - **Parameters:** `title`, `description`, `location`, etc.
  - **Response:** Created work opportunity details.

- **Show Work**
  - **Endpoint:** `GET /api/v1/work/{workId}`
  - **Description:** Retrieve details of a specific work opportunity.
  - **Parameters:** `workId`
  - **Response:** Details of the specified work opportunity.

- **Update Work**
  - **Endpoint:** `PUT /api/v1/work/{workId}`
  - **Description:** Update a specific work opportunity.
  - **Parameters:** `workId`, `title`, `description`, `location`, etc.
  - **Response:** Updated work opportunity details.

- **Delete Work**
  - **Endpoint:** `DELETE /api/v1/work/{workId}`
  - **Description:** Delete a specific work opportunity.
  - **Parameters:** `workId`
  - **Response:** Success message.

### Job Applications

- **Apply for Work**
  - **Endpoint:** `POST /api/v1/work/{workId}/apply`
  - **Description:** Apply for a specific work opportunity.
  - **Parameters:** `workId`, `resume`, `cover_letter`, etc.
  - **Response:** Application submission confirmation.

- **Get Applications**
  - **Endpoint:** `GET /api/v1/work/{workId}/applications`
  - **Description:** Retrieve all applications for a specific work opportunity.
  - **Parameters:** `workId`
  - **Response:** List of applications for the specified work opportunity.



