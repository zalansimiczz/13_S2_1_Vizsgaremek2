using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace TollÚtdíj
{
    public partial class userinterface : Form
    {
        // változók a szerepkör és a cég azonosító tárolására, hogy átadhassuk ezeket a különböző kezelő formoknak
        private string role;
        private int cegId;
        public userinterface(string role, int cegId)
        {
            InitializeComponent();
            this.role = role;
            this.cegId = cegId;
            lblhibas.Visible = false;

            // Szerepkör alapján engedélyek beállítása és ablak címének módosítása
            if (role == "operator")
            {
                this.Text = "TollÚtdíj - Operátor";
                btncegkezeles.Enabled = false;
                btnjarmukez.Enabled = false;
                btnjogsik.Enabled = false;
            }
            else if (role == "ceg_admin")
            {
                this.Text = "TollÚtdíj - Adminisztrátor";
            }
            else if (role == "rendszer_admin")
            {
                this.Text = "TollÚtdíj - Rendszer adminisztrátor";
            }
        }


       
        // Kijelentkezés gomb eseménykezelője, amely törli a session tokent, elrejti a jelenlegi ablakot és megnyitja a bejelentkező ablakot
        private void btnlogout_Click_1(object sender, EventArgs e)
        {
           
            Properties.Settings.Default.SessionToken = "";
            Properties.Settings.Default.Save();
            this.Hide();
            Login login = new Login();
            login.Closed += (s, args) => this.Close();
            login.Show();

            
        }
        // Cégkezelés gomb eseménykezelője, amely megnyitja a cégkezelő formot és elrejti a jelenlegi ablakot
        private void btncegkezeles_Click(object sender, EventArgs e)
        {
            var f = new cegkezeles(role, cegId);

            
            f.FormClosed += (s, args) =>
            {
                this.Show();
                this.Activate();
            };

            this.Hide();
            f.Show();
        }
        // Járműkezelés gomb eseménykezelője, amely megnyitja a járműkezelő formot és elrejti a jelenlegi ablakot
        private void btnjarmukez_Click(object sender, EventArgs e)
        {
            var f = new jarmukezeles(role, cegId);
            f.FormClosed += (s, args) =>
            {
                this.Show();
                this.Activate();
            };

            this.Hide();
            f.Show();
        }
        // Sofőrkezelés gomb eseménykezelője, amely megnyitja a sofőrkezelő formot és elrejti a jelenlegi ablakot
        private void btnsofor_Click(object sender, EventArgs e)
        {
            var f = new soforkezeles(role, cegId);
            f.FormClosed += (s, args) =>
            {
                this.Show();
                this.Activate();
            };

            this.Hide();
            f.Show();
        }
        // Jogosítványkezelés gomb eseménykezelője, amely megnyitja a jogosítványkezelő formot és elrejti a jelenlegi ablakot
        private void btnjogsik_Click(object sender, EventArgs e)
        {
            var f = new jogsikezeles(role, cegId);
            f.FormClosed += (s, args) =>
            {
                this.Show();
                this.Activate();
            };

            this.Hide();
            f.Show();
        }
        // Trackerkezelés gomb eseménykezelője, amely megnyitja a trakkerkezelő formot és elrejti a jelenlegi ablakot
        private void btntrackkez_Click(object sender, EventArgs e)
        {
            var f = new trackerkezeles(role, cegId);
            f.FormClosed += (s, args) =>
            {
                this.Show();
                this.Activate();
            };

            this.Hide();
            f.Show();
        }
    }
}
