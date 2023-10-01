using System.Collections.Generic;

namespace TCM.Presentation.Site.Models
{
    public class SelectUserModel
    {
        public List<Results> results { get; set; }= new List<Results>();

        public Pagination pagination { get; set; }
    }

    public class Results
    {
        public int id { get; set; }

        public string text { get; set; }
    }

    public class Pagination
    {
        public bool more { get; set; }
    }
}
