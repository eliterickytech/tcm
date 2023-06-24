﻿using Dapper;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.Options;
using Rickytech.TCM.Services.Model;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Rickytech.TCM.Infra.Reposisitory
{
    public abstract class BaseRepository
    {
        private readonly IConfiguration _configuration;

        public BaseRepository(IConfiguration configuration)
        {
            _configuration = configuration;
        }

        protected IDbConnection CreateConnection()
        {
            return new SqlConnection(_configuration.GetSection("ConnectionStrings:SQL_TCM").Value);
        }


        public async Task<IEnumerable<T>> QueryAsync<T>(string query, object parameters = null)
        {

            using (var conn = CreateConnection())
            {
                conn.Open();
                return await conn.QueryAsync<T>(query, parameters);
            }

        }

        public async Task<T> QueryFirstOrDefaultAsync<T>(string query, object parameters = null)
        {

            using (var conn = CreateConnection())
            {
                conn.Open();
                return await conn.QueryFirstOrDefaultAsync<T>(query, parameters);
            }

        }

        public async Task<int> ExecuteAsync(string query, object parameters = null)
        {

            using (var conn = CreateConnection())
            {
                conn.Open();
                return await conn.ExecuteAsync(query, parameters);
            }

        }
    }
}
