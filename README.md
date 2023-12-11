<h1> Budget App</h1>

Budget web-app maintained by [Federico Puppo](https://github.com/fedem-p) and [Davide Lanza](https://github.com/Davidelanz)

## How to use

Use this image in a `docker-compose.yml` file in order to launch a local server for a PHP-based website:

```yml
version: '3.8'

services:
  test-apache-server:
    image: ghcr.io/eikonproject/apache_dev_server:main
    volumes:
      - <WEBSITE_HTDOCS_FOLDER>:/home/htdocs
    ports:
      - <DESIRED_PORT>:8889
```

## Build locally

The [`docker-compose.yml`](./docker-compose.yml) file included here automatically builds locally the image and provide an example by mounting the [`budget-website.org`](./budget-website.org/) folder as a test PHP website.

## Data

### Categories and Subcategories

**Expense Categories:**

- Housing:
  - Rent/Mortgage
  - Utilities (Electricity, Water, Gas)
  - Property Taxes
  - Home Insurance
  - Maintenance/Repairs
  
- Transportation:
  - Fuel
  - Public Transportation
  - Vehicle Maintenance
  - Insurance
  - Parking/Tolls

- Food:
  - Groceries
  - Dining Out
  - Fast Food
  
- Health:
  - Health Insurance
  - Medications
  - Doctor Visits
  - Gym Memberships

- Entertainment:
  - Movies/Streaming Services
  - Concerts/Events
  - Hobbies
  - Subscriptions (Magazines, etc.)

- Debt Payments:
  - Credit Card Payments
  - Loan Payments

- Personal Care:
  - Haircuts
  - Toiletries
  - Clothing

- Education:
  - Tuition
  - Books/Supplies
  - Courses/Workshops

- Savings:
  - Emergency Fund
  - Retirement Savings
  - Other Savings Goals

- Miscellaneous:
  - Gifts
  - Donations
  - Pet Care

**Income Categories:**

- Salary/Wages:
  - Primary Job
  - Secondary Job/Part-Time Work

- Investment Income:
  - Dividends
  - Capital Gains

- Other Income:
  - Gifts/Inheritance
  - Lottery/Gambling Winnings
