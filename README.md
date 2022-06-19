# IP-Lookup
A Simple Tool to Lookup Informations about IP Adresses made with PHP and [IP-API](https://ip-api.com/ "IP-API")

**You can try the tool at [ip.steinlarve.de](https://ip.steinlarve.de/ "ip.steinlarve.de")**

## How it Works
1. When an IP address is entered, it is entered into the query using the GET method
2. The Website Passes the IP adress to the IP API and gets an JSON Array with all the Informations back. 
3. This JSON Array gets Converted back to readable text and Stored in a Variable
4. The most Important Information gets Displayed in an Popup on the [Leaflet Map](https://leafletjs.com/ "Leaflet Map")
5. All of the Information gets in a Table under the Map

## To Do
- Add Reverse DNS
- Add a Speedtest function
- Add a Ping measuring tool 
- Add a Whois Lookup tool
- Add maybe a Embed Widget for Websites

## Used Services
- [Leaflet](https://leafletjs.com/ "Leaflet")
- [IP-API](https://ip-api.com/ "IP-API")

------------


Made with &hearts; by LarvenStein
