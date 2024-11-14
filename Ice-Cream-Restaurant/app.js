const PORT =  502;
const express = require("express");
const app = express();
const path = require("path");
const sql=require('mysql2');
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.set("view engine", "ejs");
app.use(express.static(path.join(__dirname, "public")));


//body parser :
let BodyParser=require('body-parser');
app.use(BodyParser.json());
app.use(BodyParser.urlencoded({extended:true}));


//db :


hostname='localhost';
port=3307;
user='root';
password='';
db='icecream';
let con=sql.createConnection({
    host:hostname,port:port,user:user,password:password,database:db
})
con.connect(function(err){
    if(err)console.log(err);
    else
    console.log("conneted");
})

//get :
//get home:

app.get('/',(req,res)=>{
    let query=`select * from currentuser`;
    con.query(query,(err,result)=>{
        if(result.length>0){
            let name=result[0]['uid']
            res.render('home.ejs',{u:`${name}`});
        }
        else{
            res.render('home.ejs',{u:``});
        }
  });
});
app.get('/home',(req,res)=>{
    let query=`select * from currentuser`;
    con.query(query,(err,result)=>{
        if(result.length>0){
            let name=result[0]['uid']
            res.render('home.ejs',{u:`${name}`});
        }
        else{
            res.render('home.ejs',{u:``});
        }
  });
});
  
//get about:

app.get('/about',(req,res)=>{
    let query=`select * from currentuser`;
    con.query(query,(err,result)=>{
        if(result.length>0){
            let name=result[0]['uid']
            res.render('about_us.ejs',{u:`${name}`});
        }
        else{
            res.render('about_us.ejs',{u:``});
        }
  });
});

//get logout:

app.get('/logout',(req,res)=>{
    let query=`truncate table icecream.currentuser;`;
    con.query(query,(err,result)=>{
        if(err)throw err;
  });
    res.render("home.ejs",{u:''});
  });


//get login:
app.get('/login',(req,res)=>{
  res.render("login.ejs",{message:''});
});

//get signup:
app.get('/signup',(req,res)=>{
  res.render("signup.ejs");
});

//get reverse:
app.get('/reserve',(req,res)=>{
  res.render("reserve.ejs");
});

//get menu:
app.get('/menu', (req, res) => {
    const sql = 'SELECT * FROM menu ORDER BY itemtype';
    let id = req.query.id;
    

    if (id) {
        const sql3 = 'SELECT uid FROM currentuser';
        con.query(sql3, (err, result1) => {
            if (err) {
                console.error('Error fetching current user:', err);
                return res.status(500).send('Error fetching current user');
            }

            if (result1.length > 0) {
                let h = result1[0];
                const sql4 = `SELECT * FROM orderonline WHERE itemid=${id} AND customerid='${h['uid']}'`;
                
                con.query(sql4, (err, result2) => {
                    if (err) {
                        console.error('Error fetching order:', err);
                        return res.status(500).send('Error fetching order');
                    }

                    if (result2.length === 0) {
                        const sql2 = `INSERT INTO orderonline (itemid, customerid) VALUES (${id}, '${h['uid']}')`;
                        console.log(sql2);
                        con.query(sql2, (err, result2) => {
                            if (err) {
                                console.error('Error inserting order:', err);
                                return res.status(500).send('Error inserting order');
                            }
                            return res.redirect('/menu');
                        });
                    } else {
                        console.log('Updating quantity for user:', h['uid']);
                        const sql5 = `
                            UPDATE orderonline o
                            JOIN (SELECT id FROM orderonline WHERE itemid = ${id}) sub
                            ON o.id = sub.id
                            SET o.quantity = o.quantity + 1;
                        `;
                        con.query(sql5, (err, result2) => {
                            if (err) {
                                console.error('Error updating quantity:', err);
                                return res.status(500).send('Error updating quantity');
                            }
                        });

                       
                        return res.redirect('/menu');
                    }
                });
            } else {
                console.error('No current user found');
                return res.status(404).send('No current user found');
            }
        });
    } else {
        con.query(sql, (err, results) => {
            if (err) {
                console.error('Error fetching menu:', err);
                return res.status(500).send('Error fetching menu');
            }

            const groupedItems = results.reduce((acc, item) => {
                const { itemtype } = item;
                if (!acc[itemtype]) {
                    acc[itemtype] = [];
                }
                acc[itemtype].push(item);
                return acc;
            }, {});

            const query = 'SELECT * FROM currentuser';
            con.query(query, (err, result) => {
                if (err) {
                    console.error('Error fetching user:', err);
                    return res.status(500).send('Error fetching user');
                }

                let name = result.length > 0 ? result[0]['uid'] : '';
                res.render('menu', { items: groupedItems, u: name });
            });
        });
    }
});


//get item:

app.get('/item',(req,res)=>{
    const sql = 'SELECT * FROM menu ORDER BY itemtype';
    let id = req.query.id;
    let i = req.query.i;
    let r=req.query.r;
    let type = req.query.type;
    console.log('req.query:', req.query);
    console.log('id:', id);
    console.log('type:', type);

    if (i) {
        const sql3 = 'SELECT uid FROM currentuser';
        con.query(sql3, (err, result1) => {
            if (err) {
                console.error('Error fetching current user:', err);
                return res.status(500).send('Error fetching current user');
            }

            if (result1.length > 0) {
                let h = result1[0];
                const sql4 = `SELECT * FROM orderonline WHERE itemid=${id} AND customerid='${h['uid']}'`;
                
                con.query(sql4, (err, result2) => {
                    if (err) {
                        console.error('Error fetching order:', err);
                        return res.status(500).send('Error fetching order');
                    }

                    if (result2.length === 0) {
                        const sql2 = `INSERT INTO orderonline (itemid, customerid) VALUES (${id}, '${h['uid']}')`;
                        console.log(sql2);
                        con.query(sql2, (err, result2) => {
                            if (err) {
                                console.error('Error inserting order:', err);
                                return res.status(500).send('Error inserting order');
                            }
                            return res.redirect(`/item?id=`+r+`&type=`+type);
                        });
                    } else {
                        console.log('Updating quantity for user:', h['uid']);
                        const sql5 = `
                            UPDATE orderonline o
                            JOIN (SELECT id FROM orderonline WHERE itemid = ${id}) sub
                            ON o.id = sub.id
                            SET o.quantity = o.quantity + 1;
                        `;
                        con.query(sql5, (err, result2) => {
                            if (err) {
                                console.error('Error updating quantity:', err);
                                return res.status(500).send('Error updating quantity');
                            }
                        });

                            return res.redirect(`/item?id=`+r+`&type=`+type);
                    }
                });
            } else {
                console.error('No current user found');
                return res.status(404).send('No current user found');
            }
        });
    } else {
        con.query(sql, (err, results) => {
            if (err) {
                console.error('Error fetching menu:', err);
                return res.status(500).send('Error fetching menu');
            }

            const groupedItems = results.reduce((acc, item) => {
                const { itemtype } = item;
                if (!acc[itemtype]) {
                    acc[itemtype] = [];
                }
                acc[itemtype].push(item);
                return acc;
            }, {});

            let query=`select * from currentuser`;
    con.query(query,(err,result)=>{
        if(result.length>0){
            let name=result[0]['uid']
            res.render('item', { items: groupedItems,u:`${name}`,type:`${type}`,id:id });
        }
        else{
            res.render('item', { items: groupedItems,u:'',type:`${type}` ,id:id});
        }
    })
        });
    }
        
})



//get cart:

app.get('/cart',(req,res)=>{
const sql5 = `select uid from currentuser`;

    con.query(sql5,(err,result1)=>{
        if(err)throw err;
        else{
            const sql3 = `select * from orderonline join menu on orderonline.itemid=menu.itemid where customerid='${result1[0]['uid']}';`;
            let h;
            con.query(sql3,(err,result1)=>{
                res.render('cart.ejs',{s:result1,buy:""});
            })
        }});
    
    
})

//get delete:


app.get('/delete', (req, res) => {
    const sqlGetUser = `SELECT uid FROM currentuser`;
    
    con.query(sqlGetUser, (err, result1) => {
        if (err) {
            console.error(err);
            return res.status(500).send('Server error');
        }

        const userId = result1[0]?.uid;
        const itemId = req.query.id;

        if (!userId || !itemId) {
            return res.status(400).send('User ID or Item ID is missing');
        }

        const sqlGetQuantity = `SELECT quantity FROM orderonline WHERE customerid = ? AND itemid = ?`;
        
        con.query(sqlGetQuantity, [userId, itemId], (err, result2) => {
            if (err) {
                console.error(err);
                return res.status(500).send('Server error');
            }

            if (result2.length === 0) {
                return res.status(404).send('Item not found in cart');
            }

            const currentQuantity = result2[0].quantity;

            if (currentQuantity === 1) {
                const sqlDeleteItem = `DELETE FROM orderonline WHERE customerid = ? AND itemid = ?`;
                
                con.query(sqlDeleteItem, [userId, itemId], (err) => {
                    if (err) {
                        console.error(err);
                        return res.status(500).send('Server error');
                    }
                    return res.redirect('/cart');
                });
            } else {
                const sqlUpdateQuantity = `UPDATE orderonline SET quantity = quantity - 1 WHERE customerid = ? AND itemid = ?`;
                
                con.query(sqlUpdateQuantity, [userId, itemId], (err) => {
                    if (err) {
                        console.error(err);
                        return res.status(500).send('Server error');
                    }
                    return res.redirect('/cart');
                });
            }
        });
    });
});

//get buy:


app.get('/buy', (req, res) => {
    const sqlGetUser = `SELECT uid FROM currentuser`;
    con.query(sqlGetUser, (err, result1) => {
        if (err) {
            console.error(err);
            return res.status(500).send('Server error');
        }
        userId=result1[0]['uid'];
        const sql = `delete from  orderonline where customerid='${userId}'`;
        con.query(sql, (err, result1) => {
            if(err)throw err;
            res.render('cart',{buy:"your order will deliver soon",s:[]});
        })
    });
});







//post :

//post login :
    app.post('/',(req,res)=>{
        let name=req.body.username;
        let id=req.body.password;
        let query=`SELECT * FROM master_login where userid='${name}' and pass='${id}'`
        con.query(query,(err,result)=>{
            if(result.length>0){
                let query1=`insert into currentuser values ('${name}' )`;
                con.query(query1,(err,result)=>{
                    if(err){
                        console.log(err);
                    }
                    else{
                        console.log("insertdddddddddddd");
                    }
                })
                console.log(result);
                res.render('home.ejs',{u:`${name}`});
            }
            else{
                
                
                return res.render('login', { message: 'Invalid username or password' });

            }
        })
       
    })


//post signup :

    app.post('/signup',(req,res)=>{
        let name=req.body.username;
        let phone=req.body.phone;
        let pas=req.body.password;
        
         let query=`INSERT INTO master_login (userid,pass) VALUES ('${name}','${pas}')`
         con.query(query,(err,result)=>{
             if(err)throw err
             else
             console.log("inserted");
         })
         res.render('login.ejs',{message:''});
     })


app.listen(PORT, () => {
  console.log("Server is running..");
});