﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using TCM.Services.Model;

namespace TCM.Services.Interfaces.Services
{
    public interface ISearchServices
    {
        Task<List<ResultSearchModel>> SearchUserAsync(string search, int userId);
    }
}
