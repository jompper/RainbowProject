#!/bin/bash
cat drop-tables.sql create-tables.sql add-test-data.sql | psql
