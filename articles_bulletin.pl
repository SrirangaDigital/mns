#!/usr/bin/perl

$host = $ARGV[0];
$db = $ARGV[1];
$usr = $ARGV[2];
$pwd = $ARGV[3];

use DBI();
@ids=();

open(IN,"mns_bulletin.xml") or die "can't open mns_bulletin.xml\n";

my $dbh=DBI->connect("DBI:mysql:database=$db;host=$host","$usr","$pwd");

#vnum, number, month, year, title, feature, authid, page, 

$sth11r=$dbh->prepare("CREATE TABLE article_bulletin(title varchar(500), 
authid varchar(200),
authorname varchar(1000),
featid varchar(10),
page varchar(10), 
page_end varchar(10), 
plates varchar(1000), 
volume varchar(10),
part varchar(5),
year varchar(10), 
month varchar(6),
titleid varchar(30), primary key(titleid)) ENGINE=MyISAM");
$sth11r->execute();
$sth11r->finish();

$line = <IN>;

while($line)
{
	if($line =~ /<volume vnum="(.*)">/)
	{
		$volume = $1;
		print $volume . "\n";
	}
	elsif($line =~ /<part pnum="(.*)" month="(.*)" year="(.*)">/)
	{
		$part = $1;
		$month = $2;
		$year = $3;
		$count = 0;
		$prev_pages = "";
	}	
	elsif($line =~ /<title>(.*)<\/title>/)
	{
		$title = $1;
	}
	elsif($line =~ /<feature>(.*)<\/feature>/)
	{
		$feature = $1;
		$featid = get_featid($feature);
	}	
	elsif($line =~ /<page>(.*)<\/page>/)
	{
		$pages = $1;
		($page, $page_end) = split(/-/, $pages);
		if($pages eq $prev_pages)
		{
			$count++;
			$id = "bul_" . $volume . "_" . $part . "_" . $page . "_" . $page_end . "_" . $count; 
		}
		else
		{
			$id = "bul_" . $volume . "_" . $part . "_" . $page . "_" . $page_end . "_0";
			$count = 0;		
		}
		$prev_pages = $pages;		
	}	
	elsif($line =~ /<plates>(.*)<\/plates>/)
	{
		$plates = $1;
	}	
	elsif($line =~ /<author>(.*)<\/author>/)
	{
		$authorname = $1;
		$authids = $authids . ";" . get_authid($authorname);
		$author_name = $author_name . ";" .$authorname;
	}
	elsif($line =~ /<allauthors\/>/)
	{
		$authids = "0";
		$author_name = "";
	}
	elsif($line =~ /<\/entry>/)
	{
		insert_article($title,$authids,$author_name,$featid,$page,$page_end,$plates,$volume,$part,$year,$month,$id);
		$authids = "";
		$featid = "";
		$author_name = "";
		$id = "";
	}
	$line = <IN>;
}

close(IN);
$dbh->disconnect();

sub insert_article()
{
	my($title,$authids,$author_name,$featid,$page,$page_end,$plates,$volume,$part,$year,$month,$id) = @_;
	my($sth1);

	$title =~ s/'/\\'/g;
	$authids =~ s/^;//;
	$author_name =~ s/^;//;
	$author_name =~ s/'/\\'/g;
	
	$sth1=$dbh->prepare("insert into article_bulletin values('$title','$authids','$author_name','$featid','$page','$page_end','$plates','$volume','$part','$year','$month','$id')");
	
	$sth1->execute();
	$sth1->finish();
}

sub get_authid()
{
	my($authorname) = @_;
	my($sth,$ref,$authid);

	$authorname =~ s/'/\\'/g;
	
	$sth=$dbh->prepare("select authid from author where authorname='$authorname'");
	$sth->execute();
			
	my $ref = $sth->fetchrow_hashref();
	$authid = $ref->{'authid'};
	$sth->finish();
	return($authid);
}

sub get_featid()
{
	my($feature) = @_;
	my($sth,$ref,$featid);

	$feature =~ s/'/\\'/g;
	
	$sth=$dbh->prepare("select featid from feature_bulletin where feat_name='$feature'");
	$sth->execute();
			
	my $ref = $sth->fetchrow_hashref();
	$featid = $ref->{'featid'};
	$sth->finish();
	return($featid);
}
